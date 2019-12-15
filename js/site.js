$(document).ready(function(){

    $('.modalLink').modal({
        trigger: '.modalLink',          
        olay:'div.overlay',             
        modals:'div.modal',             
        animationEffect: 'slideDown',   
        animationSpeed: 50,            
        moveModalSpeed: 'fast',         
        background:'default',         
        opacity: 0.5,                   
        openOnLoad: false,              
        docClose: true,                     
        closeByEscape: true,           
        moveOnScroll: true,             
        resizeWindow: true,             
        close:'.closeBtn'               
    });
});