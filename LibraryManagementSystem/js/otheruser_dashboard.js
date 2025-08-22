
        function openpart(portionId) {
            var portions = document.querySelectorAll('.portion');
            portions.forEach(p => p.style.display = 'none');
            
            document.getElementById(portionId).style.display = 'block';
        }
        
        // This is a small bugfix to handle the initial state
        document.addEventListener('DOMContentLoaded', function() {
            var urlParams = new URLSearchParams(window.location.search);
            if(urlParams.has('returnid')) {
                openpart('return');
            } else {
                openpart('myaccount');
            }
        });
    