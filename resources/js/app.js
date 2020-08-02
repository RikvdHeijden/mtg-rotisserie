require('./bootstrap');

Echo.channel('draft.1').listen('DraftStarts', e => {
    console.log(e);
})

console.log('test 2');
