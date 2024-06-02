import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Arrow } from './component/Icons';

const Save = (props) => {
	const { attributes } = props;
	const { faqs } = attributes;
	const blockProps = useBlockProps.save();

	return (
		<div className='faq-block-wrapper'>
			<dl {...blockProps}>
				{faqs.map((item, index) => (
					<div key={index} className='clickable-faq'>
						<dt className='description-title'>
							<RichText.Content tagName="p" value={item.question} />
							<Arrow />
						</dt>
						<dd className="description">
							<div>
								<RichText.Content tagName="p" value={item.question} />
							</div>
						</dd>
					</div>
				))}
			</dl>
		</div>
	);
};

export default Save;
