function doAIprompt(){
    let ai_request_route = document.querySelector('[name="ai_request_route"]').content;
    let csrf_token = document.querySelector('[name="csrf_token"]').content;
    

    document.getElementById('AIprompt').addEventListener('submit', function (e) {
        e.preventDefault();
    
        const prompt = document.getElementById('prompt').value;
    
        fetch('/doAIprompt', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ prompt: prompt })
        })
        .then(response => response.json())
        .then(data => {
            // Display the response in an element with id "summary"
            document.getElementById('summary').innerHTML = data.response;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}