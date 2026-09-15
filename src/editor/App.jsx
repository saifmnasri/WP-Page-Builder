import { useEffect, useState, useCallback } from 'react';
import { Puck } from '@puckeditor/core';
import '@puckeditor/core/puck.css';
import { puckConfig } from './config/puck-config';
import { fetchLayout, saveLayout } from './store/api';

export default function App( { postId } ) {
	const [ data, setData ] = useState( null );

	useEffect( () => {
		fetchLayout( postId ).then( ( res ) => {
			setData( res.layout || { content: [], root: {} } );
		} );
	}, [ postId ] );

	const handlePublish = useCallback( ( newData ) => {
		saveLayout( postId, newData );
	}, [ postId ] );

	if ( ! data ) return <div style={ { padding: '2rem' } }>Loading…</div>;

	return <Puck config={ puckConfig } data={ data } onPublish={ handlePublish } />;
}