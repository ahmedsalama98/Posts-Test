



let addPostForm = document.getElementById('addPostForm');

if(addPostForm != undefined && addPostForm != null){

    addPostForm.addEventListener('submit', (event)=>{
        event.preventDefault();


if(checkEmptyValues().length ==0){
    let myFormData = new FormData(addPostForm);
    let url =addPostForm.action ;

    fetch(url,{body:myFormData , method:'POST'}  )
    .then(res => res.json())
    .then((data)=>{
        if(data.success){
            if(addPostForm.dataset.target!= 'edit'){
                clearFieldsValue();

            }
            document.getElementById('add-post-massage').innerHTML= ` <div class="alert alert-success">${data.message}</div>`
        }

    })
    .catch(error =>  {
        console.log(error)
    })
}


    })
}
function clearFieldsValue (){
    document.getElementById('title').value =""
    document.getElementById('description').value =""
    document.getElementById('image').value =""
}
function checkEmptyValues(){
    let title = document.getElementById('title'),
    description= document.getElementById('description'),
    errors =[];

    if(title.value.length < 1){
        errors.push('title')
    }
    if(description.value.length < 1){
        errors.push('description')
    }

    return errors;

}



let postLikeButton = document.querySelector('.likes_btn'),
    postLikeCount =document.querySelector('.likes_count ');

postLikeButton.addEventListener('click', (event)=>{

    isLiked =postLikeButton.dataset.active ;


    if(isLiked =='true'){
        event.target.dataset.active ='false'
        postLikeCount.textContent = parseInt(postLikeCount.dataset.count) -1;
        postLikeCount.dataset.count=parseInt(postLikeCount.dataset.count) -1;

    }else{
        postLikeCount.textContent = parseInt(postLikeCount.dataset.count) +1;
        event.target.dataset.active ='true'
        postLikeCount.dataset.count= parseInt(postLikeCount.dataset.count) +1;

    }

    let myForm = document.querySelector('.likes form'),
        myFormData =new FormData(myForm),
        url = myForm.action;

        fetch(url,{body:myFormData , method:'POST'}  )
        .then(res => res.json())
        .then((data)=>{
         console.log(data)

        })
        .catch(error =>  {
            console.log(error)
        })

})


let addComment =document.getElementById('add-comment');


addComment.addEventListener('submit', (event)=>{
    event.preventDefault();



let myFormData = new FormData(addComment);
let url =addComment.action ;

fetch(url,{body:myFormData , method:'POST'}  )
.then(res => res.json())
.then((data)=>{
    console.log(data)

    document.getElementById('comment_field').value ="";
    let comment =`<div class="comment">
    <p>You</p>
    <span>Now</span>

    <p>${data.data.comment}</p>
</div>`


document.querySelector('.comments').innerHTML = comment +document.querySelector('.comments').innerHTML;
alert('Added Successfully');
console.log(x)


})
.catch(error =>  {
    console.log(error)
})



})
