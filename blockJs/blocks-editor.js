const withAnchor = props => {
    // if (props.attributes) { // Some blocks don't have attributes
    //     props.attributes = {
    //         ...props.attributes,
    //         anchor: {
    //             type: 'string'
    //         }
    //     }
    // }
    return props
}

wp.hooks.addFilter(
    'blocks.registerBlockType',
    'namespace/with-anchor',
    withAnchor
)