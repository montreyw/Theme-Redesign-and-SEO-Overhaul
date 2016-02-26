(function() {
    tinymce.PluginManager.add('andres_interview_buttons', function( editor, url ) {
        editor.addButton( 'andres_interview_question', {
            title: 'Interview Queston',
//             icon: 'icon fa fa-question',
            text: 'IQ',
            onclick: function() {
                editor.selection.setContent('<h6 class="post-question">' + editor.selection.getContent() + '</h6>');
            }
        });
        editor.addButton( 'andres_interview_answer', {
            title: 'Interview Answer',
//             icon: 'icon fa fa-comment-o',
            text: 'IA',
            onclick: function() {
                editor.selection.setContent('<h6 class="post-answer">' + editor.selection.getContent() + '</h6>');
            }
        });
    });
})(); 