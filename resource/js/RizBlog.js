//TODO change this to get info from DB
$('.blog-roll .blog-roll-panel ul li:first').click(function (e) {
    $('input.title').attr('value', 'I can totally write a blog title');
    $('.editor-content').froalaEditor('html.set', '<p>here is riz writing a wonderful blog post in the train like ya can not even imagine how quickly i have written this can you tell i am totally make sentences up to fill up the space am i filling up space enough yet like what even is the meaning of life you know');
});
$('.blog-roll .blog-roll-panel ul li:last').click(function (e) {
    $('input.title').attr('value', 'In recognition of the Jonas Brothers');
    $('.editor-content').froalaEditor('html.set', '<p>right song lyrics in celebration of the jonas brothers here goes : oohhhh this is an SOS dont wanna second guess this is the BOTTOM LINE its true i gave my all for and now my hearts in twooooo oooooohhhh</p>');
});
// Initialize the editor.
$('.editor-content').froalaEditor();
//# sourceMappingURL=RizBlog.js.map