document.addEventListener("DOMContentLoaded", () => {
    // Get references to elements
    const lookupButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");

    // Function to handle fetching data from world.php
    function fetchData(url) {
        fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); // Parse the response as text
            })
            .then((data) => {
                // Insert the fetched data into the result div
                resultDiv.innerHTML = data;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                resultDiv.innerHTML = "<p>Something went wrong. Please try again later.</p>";
            });
    }

    // Lookup button listener for country data
    lookupButton.addEventListener("click", () => {
        const countryInput = document.getElementById("country");
        const country = countryInput.value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}`; // Query for country data
        fetchData(url);
    });

    // Lookup Cities button listener for city data
    lookupCitiesButton.addEventListener("click", () => {
        const countryInput = document.getElementById("country");
        const country = countryInput.value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}&lookup=cities`; // Query for city data
        fetchData(url);
    });
});
