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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import VueCkeditor from 'vue-ckeditor5'

const options = {
    editors: {
        classic: ClassicEditor,
    },
    name: 'ckeditor'
};

Vue.use(VueCkeditor.plugin, options);
