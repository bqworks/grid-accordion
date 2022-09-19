import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { InspectorControls } from '@wordpress/blockEditor';
import { SelectControl, Placeholder } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { gridAccordionIcon } from './icons';

import './editor.scss';

export default function edit( props ) {
	const { attributes, setAttributes } = props;
	const [ accordions, setAccordions ] = useState([]);

	// Create a global object to store the accordion data, so
	// that it needs to be fetched only once, when the first
	// block is added. Additional blocks will use the accordion
	// data stored in the global object.
	if ( typeof window.gridAccordion === 'undefined' ) {
		window.gridAccordion = {
			accordions: [],
			accordionsDataStatus: '' // can be '', 'loading' or 'loaded'
		};
	}

	// Load the accordion data and store the accordion name and id,
	// as 'label' and 'value' to be used in the SelectControl.
	const getAccordionsData = () => new Promise( ( resolve ) => {
		wp.apiFetch({
			path: 'grid-accordion/v1/accordions'
		}).then( function( responseData ) {
			let accordionsData = [];
			
			for ( const key in responseData ) {
				accordionsData.push({
					label: `${ responseData[ key ] } (${ key })`,
					value: parseInt( key )
				});
			}

			resolve( accordionsData );
		});
	});

	// Get a accordion by its id.
	const getAccordion = ( accordionId ) => {
		const accordion = accordions.find( ( accordion ) => {
			return accordion.value === accordionId;
		});

		return typeof accordion !== 'undefined' ? accordion : false;
	};

	// Get the accordion's label by its id.
	const getAccordionLabel = ( accordionId ) => {
		const accordion = getAccordion( accordionId );

		return accordion !== false ? accordion.label: '';
	};

	// Initialize the component by setting the 'accordions' property
	// which will trigger the rendering of the component.
	//
	// If the accordions data is already globally available, set the 'accordions'
	// immediately. If the accordions data is currently loading, wait for it
	// to load and then set the 'accordions'. If it's not currently loading,
	// start the loading process.
	const init = () => {
		if ( window.gridAccordion.accordionsDataStatus === 'loaded' ) {
			setAccordions( window.gridAccordion.accordions );
		} else if ( window.gridAccordion.accordionsDataStatus === 'loading' ) {
			const checkApiFetchInterval = setInterval( function() {
				if ( window.gridAccordion.accordionsDataStatus === 'loaded' ) {
					clearInterval( checkApiFetchInterval );
					setAccordions( window.gridAccordion.accordions );
				}
			}, 100 );
		} else {
			window.gridAccordion.accordionsDataStatus = 'loading';

			getAccordionsData().then( ( accordionsData ) => {
				window.gridAccordion.accordionsDataStatus = 'loaded';
				window.gridAccordion.accordions = accordionsData;

				setAccordions( accordionsData );
			});
		}
	}

	useEffect( () => {
		init();
	}, [] );

	return (
		<div { ...useBlockProps() }>
			<Placeholder label='Grid Accordion' icon={ gridAccordionIcon }>
				{
					window.gridAccordion.accordionsDataStatus !== 'loaded' ?
						<div className='sp-gutenberg-accordion-placeholder-content'> { __( 'Loading Grid Accordion data...', 'grid-accordion' ) } </div>
					: (
						window.gridAccordion.accordions.length === 0 ?
							<div className='sp-gutenberg-accordion-placeholder-content'> { __( 'You don\'t have any created accordions yet.', 'grid-accordion' ) } </div>
						: (
							getAccordion( attributes.accordionId ) === false ?
								<div className='sp-gutenberg-accordion-placeholder-content'> { __( 'Select a accordion from the Block settings.', 'grid-accordion' ) } </div>
							: (
								<div className='sp-gutenberg-accordion-placeholder-content'>
									<p className='sp-gutenberg-accordion-identifier'> { getAccordionLabel( attributes.accordionId ) } </p>
									<a className='sp-gutenberg-edit-accordion' href={`${ sp_gutenberg_js_vars.admin_url }?page=grid-accordion&id=${ attributes.accordionId }&action=edit`} target='_blank'> { __( 'Edit Accordion', 'grid-accordion' ) } </a>
								</div>
							)
						)
					)
				}
			</Placeholder>

			<InspectorControls>
				<SelectControl
					className='sp-gutenberg-select-accordion'
					label={ __( 'Select a accordion from the list:', 'grid-accordion' ) }
					options={ [ { label: __( 'None', 'grid-accordion'), value: -1 }, ...accordions ] }
					value={ attributes.accordionId }
					onChange={ ( newAccordionId ) => setAttributes( { accordionId: parseInt( newAccordionId ) } ) }
				/>
				{
					window.gridAccordion.accordions.length === 0 &&
					<p 
						className='sp-gutenberg-no-accordions-text'
						dangerouslySetInnerHTML={{
							__html: sprintf( __( 'You don\'t have any created accordions yet. You can create and manage accordions in the <a href="%s" target="_blank">dedicated area</a>, and then use the block to load the accordions.', 'grid-accordion' ), `${ sp_gutenberg_js_vars.admin_url }?page=grid-accordion` )
						}}>
					</p>
				}
			</InspectorControls>
		</div>
	);
}
