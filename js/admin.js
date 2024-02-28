let header = document.querySelector('.header');

document.querySelector('#menu-btn').onclick = () => {
    header.classList.toggle('active');
    
}
window.onscroll = () => {
    header.classList.remove('active');

}

document.querySelectorAll('.posts-content').forEach(content => {
    let words = content.innerText.match(/\S+/g); 
    if (words && words.length > 5) {
        let truncatedContent = words.slice(0, 5).join(' '); 
        content.innerText = truncatedContent + '...';
    }
});
