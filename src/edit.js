import { __ } from '@wordpress/i18n';
import { Button, Dashicon, Tooltip } from '@wordpress/components';
import { useBlockProps, RichText } from '@wordpress/block-editor';

const Edit = ({ attributes, setAttributes }) => {
	const { faqs = [] } = attributes;

	const addQA = () => {
		const newQuestions = [...faqs, { question: '', answer: '' }];
		setAttributes({ faqs: newQuestions });
	};

	const removeQA = (index) => {
		const newQuestions = [...faqs];
		newQuestions.splice(index, 1);
		setAttributes({ faqs: newQuestions });
	};

	const duplicateQA = (index) => {
		const newQuestions = [...faqs];
		const duplicateItem = { ...newQuestions[index] };
		newQuestions.splice(index + 1, 0, duplicateItem);
		setAttributes({ faqs: newQuestions });
	};

	const updateQuestion = (value, index) => {
		const newQuestions = [...faqs];
		newQuestions[index].question = value;
		setAttributes({ faqs: newQuestions });
	};

	const updateAnswer = (value, index) => {
		const newQuestions = [...faqs];
		newQuestions[index].answer = value;
		setAttributes({ faqs: newQuestions });
	};

	const moveFAQUp = (index) => {
		if (index === 0) return;
		const newFAQs = [...faqs];
		const temp = newFAQs[index - 1];
		newFAQs[index - 1] = newFAQs[index];
		newFAQs[index] = temp;
		setAttributes({ faqs: newFAQs });
	};

	const moveFAQDown = (index) => {
		if (index === faqs.length - 1) return;
		const newFAQs = [...faqs];
		const temp = newFAQs[index + 1];
		newFAQs[index + 1] = newFAQs[index];
		newFAQs[index] = temp;
		setAttributes({ faqs: newFAQs });
	};

	return (
		<div className='myfaq-block-editor' {...useBlockProps()}>
			{faqs.map((item, index) => (
				<div key={index} className='clickable-faq'>
					<dt className='description-title'>
						<RichText
							tagName="p"
							value={item.question}
							onChange={(value) => updateQuestion(value, index)}
							placeholder={__('Question...', 'faq-block')}
						/>
					</dt>
					<dd className="description">
						<RichText
							tagName="p"
							value={item.answer}
							onChange={(value) => updateAnswer(value, index)}
							placeholder={__('Answer...', 'faq-block')}
						/>
					</dd>
					<div className='faq-block-tools'>
						<Tooltip text={__('Remove FAQ', 'faq-block')}>
							<Button
								isDestructive
								onClick={() => removeQA(index)}
							>
								<Dashicon icon="trash" />
							</Button>
						</Tooltip>
						<Tooltip text={__('Duplicate FAQ', 'faq-block')}>
							<Button
								isSecondary
								onClick={() => duplicateQA(index)}
							>
								<Dashicon icon="admin-page" />
							</Button>
						</Tooltip>
						<Tooltip text={__('Move FAQ Up', 'faq-block')}>
							<Button
								isSecondary
								onClick={() => moveFAQUp(index)}
								disabled={index === 0}
							>
								<Dashicon icon="arrow-up-alt2" />
							</Button>
						</Tooltip>
						<Tooltip text={__('Move FAQ Down', 'faq-block')}>
							<Button
								isSecondary
								onClick={() => moveFAQDown(index)}
								disabled={index === faqs.length - 1}
							>
								<Dashicon icon="arrow-down-alt2" />
							</Button>
						</Tooltip>
					</div>
				</div>
			))}
			<div class="editor-add-new-faq-faqit">
				<Button isPrimary onClick={addQA}>
					{__('Add FAQ', 'faq-block')}
				</Button>
			</div>
		</div>
	);
};

export default Edit;
