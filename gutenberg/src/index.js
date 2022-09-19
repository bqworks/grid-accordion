import { registerBlockType } from '@wordpress/blocks';
import { gridAccordionIcon } from './icons';
import edit from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType( metadata, {
	icon: gridAccordionIcon,
	edit,
	save,
});
