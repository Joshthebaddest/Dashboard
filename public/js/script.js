const ele = document.querySelectorAll('nav ul li');

ele.forEach(li => {
    const match = location.href.split('/public').includes(li.children[0].getAttribute('href').split('.')[1])
    if(match){
        li.classList.add('bg-gray-800');
    }else{
        li.classList.remove('bg-gray-800');
    }
})


document.querySelectorAll('.delete').forEach(btn =>{
    btn.addEventListener('click', function (){
        document.getElementById('popup').classList.toggle('hidden')
        document.getElementById('popup-message').classList.toggle('hidden')
    })
})

document.querySelectorAll('.popup-btn').forEach(btn =>{
    btn.addEventListener('click', function (){
        document.getElementById('popup').classList.toggle('hidden')
        document.getElementById('popup-message').classList.toggle('hidden')
    })
})

document.querySelectorAll('.dropdown-selector').forEach(container => {
    container.addEventListener('click', function(){
        if(this.offsetParent.children[1]){
            this.offsetParent.children[1].classList.toggle('hidden');
        }
    })

    // Optional: Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
        document.querySelectorAll('.dropdown-selector').forEach(dropdown => {
            if(dropdown.offsetParent.children[1]){
                if (!dropdown.contains(e.target) && !dropdown.offsetParent.children[1].contains(e.target)) {
                    dropdown.offsetParent.children[1].classList.add('hidden');
                }
            }
        })
    });
})




document.getElementById('fileInput').addEventListener('change', function(e){
    document.getElementById('profileImg').setAttribute('src', URL.createObjectURL(e.target.files[0]))
})


