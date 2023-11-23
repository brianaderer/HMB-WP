import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { useEffect, useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import './editor.scss';
import { ToggleControl, TextControl } from "@wordpress/components";

export default function Edit({ attributes, setAttributes }) {
	const [content, setContent] = useState('');
	const [additionalData, setAdditionalData] = useState(attributes.additionalData);

	// Function to update the additionalData
	const updateAdditionalData = (value) => {
		setAdditionalData(value);
		setAttributes({ additionalData: value });
	};

	// Initialize additionalData on mount
	useEffect(() => {
		if (attributes.additionalData === '') {
			setAttributes({ additionalData: 'foo' });
		}
	}, [attributes.additionalData, setAttributes]);

	// Fetch content when additionalData changes
	useEffect(() => {
		if (attributes.additionalData !== '') {
			apiFetch({
				path: '/wp/v2/block-renderer/create-block/dynamic',
				method: 'POST',
				data: {
					context: 'edit',
					additionalData: attributes.additionalData // Use the attribute directly
				}
			})
				.then(response => {
					setContent(response.rendered);
				})
				.catch(error => console.error('Error fetching block content:', error));
		}
	}, [attributes.additionalData]); // Depend on attributes.additionalData

	return (
		<>
			<div {...useBlockProps()}>
					<TextControl
						label="Additional Data"
						value={additionalData}
						onChange={(value) => updateAdditionalData(value)}
					/>
				<div dangerouslySetInnerHTML={{ __html: content }} />
			</div>
		</>
	);
}
