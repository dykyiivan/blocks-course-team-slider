import { registerBlockType } from '@wordpress/blocks';
import './style.scss';

// eslint-disable-next-line import/default
import Edit from './edit';
import save from './save';
import meta from '../block.json';

registerBlockType(meta.name, {
	edit: Edit,
	save,
});



