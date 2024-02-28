let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   searchForm.classList.remove('active');
   profile.classList.remove('active');
}

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   searchForm.classList.remove('active');
   navbar.classList.remove('active');
}

let searchForm = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () =>{
   searchForm.classList.toggle('active');
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
   navbar.classList.remove('active');
   searchForm.classList.remove('active');
}

document.querySelectorAll('.post-content').forEach(content => {
   let words = content.innerText.trim().split(/\s+/); // Split content into words
   if (words.length > 5) { // Check if there are more than 5 words
       let truncatedContent = words.slice(0, 5).join(' '); // Truncate content to first 5 words
       content.innerText = truncatedContent + '...'; // Add ellipsis
   }
});

document.querySelectorAll('.content-150').forEach(content => {
   if(content.innerHTML.length > 150) content.innerHTML = content.innerHTML.slice(0, 150);
});



