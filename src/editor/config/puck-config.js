export const puckConfig = {
	components: {
		Placeholder: {
			fields: { text: { type: 'text' } },
			defaultProps: { text: 'Drop widgets here' },
			render: ( { text } ) => (
				<div style={ { padding: 20, border: '1px dashed #ccc' } }>{ text }</div>
			),
		},
	},
};