Vue.component(
    'motor-cms-page-template',
    require('./components/PageTemplate.vue').default
);

Vue.component(
    'motor-cms-page-template-sections',
    require('./components/PageTemplateSections.vue').default
);


Vue.component(
    'motor-cms-page-component-modal',
    require('./components/PageComponentModal.vue').default
);

// Import date picker css
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

// Import ckeditor
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue';

const options = {
    editors: {
        classic: ClassicEditor,
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],

    },
    name: 'ckeditor'
};

Vue.use(CKEditor, {
    editor: ClassicEditor,
    editors: {
        classic: ClassicEditor
    }
});
