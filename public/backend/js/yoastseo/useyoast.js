import { AnalysisWorkerWrapper, createWorker, Paper } from "/backend/assets/plugins/yoastseo";

// `url` needs to be the full URL to the script for the browser to know where to load the worker script from.
// This should be the script created by the previous code-snippet.
const url = "/backend/js/yoastseo/useyoast.js"

const worker = new AnalysisWorkerWrapper( createWorker( url ) );

worker.initialize( {
    locale: "en_US",
    contentAnalysisActive: true,
    keywordAnalysisActive: true,
    logLevel: "ERROR",
} ).then( () => {
    // The worker has been configured, we can now analyze a Paper.
    const paper = new Paper( "Text to analyze", {
        keyword: "analyze",
    } );

    return worker.analyze( paper );
} ).then( ( results ) => {
    console.log( 'Analysis results:' );
    console.log( results );
} ).catch( ( error ) => {
    console.error( 'An error occured while analyzing the text:' );
    console.error( error );
} );
