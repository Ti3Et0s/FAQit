import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Arrow } from './component/Icons';

const Save = (props) => {
	const { attributes } = props;
	const { faqs, arrowColor } = attributes;
	const blockProps = useBlockProps.save();

	return (
		<div className='faqit-block-wrapper'>
			<dl {...blockProps}>
				{faqs.map((item, index) => (
					<div key={index} className='clickable-faq'>
						<dt className='description-title'>
							<RichText.Content tagName="p" value={item.question} />
							<Arrow color={arrowColor} />
						</dt>
						<dd className="description">
							<div>
								<RichText.Content tagName="p" value={item.answer} />
							</div>
						</dd>
					</div>
				))}
			</dl>
		</div>
	);
};

export default Save;
