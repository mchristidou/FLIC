function looks_like_email(str) {
    var result=true;
                    
    var ampersatPos = str.indexOf("@");    
    var dotPos = str.indexOf(".");         
    var dotPosAfterAmpersat = str.indexOf(".", ampersatPos); 
    
    if (ampersatPos<=0) result = false; 
    
    if (dotPos<0) result = false; 
    
    if (dotPosAfterAmpersat-ampersatPos==1) result = false; 
    
    if ( str.indexOf(".")==0  ||  str.lastIndexOf(".")==str.length-1 ) result = false; 
    
    return result;
}

function validate_form() { //validates sign up form
    var result=true;

    var errorMessage = '';

    var email=document.getElementById("email").value;
    if ( !looks_like_email(email) ) {
        result=false;
        errorMessage = errorMessage + "Το email δεν είναι αποδεκτό!\n";
    } 

    var email_conf=document.getElementById("email_conf").value;
    if (email_conf!=email){
        result=false;
        errorMessage = errorMessage + "To email δεν είναι επαληθεύεται!\n";
    }
    
    var birthday = new Date();
    birthday = document.getElementById("birthday").valueAsDate;
    var d1 = new Date(2008,1,1);
    if (!birthday) {
      result = false;
      errorMessage += "Πρέπει να εισάγετε την ημερομηνία γέννησής σας!\n";
    } else if (birthday > d1) {
      result=false;
      errorMessage = errorMessage + "Θα πρέπει να είστε 16 και άνω!";
    }

    var fav_genre = document.getElementById("fave_genre").selectedIndex;
    if (!fav_genre) {
      result = false;
      errorMessage += "Πρέπει να εισάγετε το αγαπημένο σας είδος!\n";
    } else if (fav_genre<1) {   
      result=false;
      errorMessage = errorMessage + "Δεν επιλέξατε αγαπημένο είδος ταινίας!\n";
    } 

    if (errorMessage!=='')
      alert(errorMessage);

    return result;
}

function validate_title() { //validates list title
  var result=true;

  var errorMessage = '';

  var list_title = document.getElementById("list_title").value;
  if (list_title == null || list_title == '') {   
    result=false;
    errorMessage = errorMessage + "Δεν δώσατε τίτλο!\n";
  }

  if (errorMessage!=='')
    alert(errorMessage);

  return result;
}

function togglelike() { //toggles like button

  var result = true;
  let like = document.getElementById("like");
  let unlike = document.getElementById("unlike");

  if (unlike.style.display === "none") { //strict equality?
    like.style.display = "none";
    unlike.style.display = "inline-block";
    result = true;
  } else {
    like.style.display = "inline-block";
    unlike.style.display = "none";
    result = false;
  }

  return result;

}

function selected(element) {
  let avatars = document.getElementsByClassName("avatarpic");
  
  // Remove border from all avatars
  for (let i = 0; i < avatars.length; i++) { //maybe find a better way?
    avatars[i].style.border = "none";
  }

  // Add border to the selected avatar
  element.style.border = "3px solid black";

  // Set hidden input value (using alt attribute)
  document.getElementById("selectedAvatar").value = element.alt;

  return false;
}


//------------- STAR RATING --------------// 

// Add event listener to star ratings for animation effect
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.star-rating:not(.readonly) label').forEach(star => {
    star.addEventListener('click', function() {
      this.style.transform = 'scale(1.2)';
      setTimeout(() => {
        this.style.transform = 'scale(1)';
      }, 200);
    });
  });
});

// Initialize star ratings for readonly containers
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.star-rating-readonly').forEach(container => {
    const rating = container.getAttribute('data-rating'); // also returns "3"
    const stars = container.querySelectorAll('svg');
    stars.forEach((star, index) => {
      if (index < rating) star.classList.add('filled');
    });
  });
});


//  ------------- AJAX LOADING FOR OTHER MOVIES SECTION --------------//
function initOtherMoviesAjaxLoader() {
    const container = document.getElementById('other-movies-section');
    if (!container) return; // Exit if the container doesn't exist

    function loadMovies(page) {
        // Save the current scroll position relative to the container
        const containerTop = container.getBoundingClientRect().top + window.scrollY;
        const currentScroll = window.scrollY - containerTop;

        container.innerHTML = '<p>Loading movies...</p>';

        fetch(`other_movies_ajax.php?page=${page}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                container.innerHTML = html;

                // Restore scroll so the container stays in place
                window.scrollTo({
                    top: containerTop + currentScroll,
                    behavior: 'instant' // or 'auto'
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
                container.innerHTML = '<p style="color:red;">Failed to load movies. Please try again.</p>';
            });
    }

    document.addEventListener('click', function(e) {
        const clickedLink = e.target.closest('#other-movies-section a[data-page]');
        
        if (clickedLink) {
            e.preventDefault();
            const pageNumber = clickedLink.dataset.page;
            if (pageNumber) loadMovies(pageNumber);
        }
    });

    loadMovies(1);

};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initOtherMoviesAjaxLoader);

// ----------------------------- AJAX LIVE SEARCH -------------------------------//
// This function is called when the user types in the search box
// It sends an AJAX request to the server to get matching movie titles
// and displays them in a dropdown list
function showResult(str) {
    if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = "";
        document.getElementById("livesearch").style.border = "0px";
        return;
    }
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("livesearch").innerHTML = this.responseText;
            //document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET", "livesearch.php?q=" + encodeURIComponent(str), true);
    xmlhttp.send();
}

function selectMovie(id, title) {
    document.querySelector('input[onkeyup]').value = title; // set main input
    document.getElementById('movie_id').value = id; // set hidden id
    document.getElementById("livesearch").innerHTML = "";
    document.getElementById("livesearch").style.border = "0px";
}
