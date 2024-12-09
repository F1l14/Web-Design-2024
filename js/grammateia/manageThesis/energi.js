// Get the current URL
const queryParams = new URLSearchParams(window.location.search);

// Retrieve the 'thesisId' parameter
const thesisId = queryParams.get('thesisId');

window.addEventListener("load", function(){
    stateProtect("energi", thesisId, "grammateia")
});