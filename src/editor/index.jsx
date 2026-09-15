import { createRoot } from 'react-dom/client';
import App from './App';

const mount = document.getElementById( 'pb-editor-root' );

if ( mount ) {
	const postId = parseInt( mount.dataset.postId, 10 );
	createRoot( mount ).render( <App postId={ postId } /> );
}