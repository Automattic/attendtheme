/**
 * Block dependencies
 */
import classnames from 'classnames';
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n;

const { Fragment } = wp.element;

const { registerBlockType } = wp.blocks;

const { InnerBlocks } = wp.editor;

const TEMPLATE = [ [ 'core/columns', {}, [
    [ 'core/column', {}, [
        [ 'core/image' ],
    ] ],
    [ 'core/column', {}, [
	    [ 'core/heading', { placeholder: 'Speaker Name' } ],
        [ 'core/paragraph', { placeholder: 'Speaker Bio' } ],
    ] ],
] ] ];

/**
 * Register example block
 */
export default registerBlockType(
    'attend/speaker',
    {
        title: __( 'Speaker', 'attend' ),
        description: __( 'Custom Column Block.', 'attend'),
        category: 'layout',
        icon: 'id-alt',
        keywords: [
            __( 'Columns', 'attend' ),
        ],
        attributes: {
      	},

		edit( { className } ) {
			return (
				<div className={ className }>
					<InnerBlocks
						template={ TEMPLATE }
					/>
				</div>
			);
		},

		save() {
			return (
				<div>
					<InnerBlocks.Content />
				</div>
			);
		}
    },
);

