import { createRoot } from 'react-dom/client';
import App from './App';

const mount = document.getElementById( 'pb-editor-root' );

if ( mount ) {
	createRoot( mount ).render( <App /> );
}