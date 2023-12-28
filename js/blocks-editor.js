const { createHigherOrderComponent } = wp.compose;
const { addFilter } = wp.hooks;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

const extendCoreParagraph = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        // Check if we're editing the 'core/paragraph' block
        if (props.name !== 'core/paragraph') {
            return <BlockEdit {...props} />;
        }

        // Add a new attribute for raw text content
        const { attributes, setAttributes } = props;
        const { rawTextContent } = attributes;
        const updateRawTextContent = (value) => {
            setAttributes({ rawTextContent: value });
        };

        return (
            <Fragment>
                <BlockEdit {...props} />
                <InspectorControls>
                    <PanelBody title="Additional Settings">
                        <TextControl
                            label="Raw Text Content"
                            value={rawTextContent}
                            onChange={updateRawTextContent}
                        />
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    };
}, 'extendCoreParagraph');

addFilter('editor.BlockEdit', 'my-plugin/extend-core-paragraph', extendCoreParagraph);
