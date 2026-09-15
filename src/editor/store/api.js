const { restUrl, nonce } = window.pbData;

export async function fetchLayout( postId ) {
	const res = await fetch( `${ restUrl }/layout/${ postId }`, {
		headers: { 'X-WP-Nonce': nonce },
	} );
	return res.json();
}

export async function saveLayout( postId, layout ) {
	const res = await fetch( `${ restUrl }/layout/${ postId }`, {
		method: 'POST',
		headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': nonce },
		body: JSON.stringify( { layout } ),
	} );
	return res.json();
}