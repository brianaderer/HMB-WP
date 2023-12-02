import { useBlockProps } from '@wordpress/block-editor';
import { TextControl } from "@wordpress/components";

export default function Edit({ attributes, setAttributes }) {

	// Function to update the additionalData
	const updateAdditionalData = (value) => {
		setAttributes({ additionalData: value });
	};
	console.log(attributes);

	return (
		<>
			<div {...useBlockProps()}>
				<TextControl
					label="Add the Instagram API key here"
					value={attributes.additionalData || ''} // Directly use attributes for value
					onChange={updateAdditionalData} // Simplified to use the function directly
				/>
			</div>
		</>
	);
}
