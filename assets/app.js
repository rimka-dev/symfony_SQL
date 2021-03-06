/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
//import './bootstrap';
import React from "react";
import ReactDom from "react-dom";
import {SearchAnnonce} from "./components/SearchAnnonce";


function App(){
    
    return(
        <>
        <div>Cherchez dans votre région!</div>
        <SearchAnnonce/>
        </>
    )
}

ReactDom.render(<App/>, document.getElementById("root"))
