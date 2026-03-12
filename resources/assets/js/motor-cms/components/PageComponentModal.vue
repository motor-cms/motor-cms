<template>
    <div id="motor-component-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xlg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button class="close" type="button" @click="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body motor-cms-components d-none">
                    <template v-for="(group, name, index) in availableComponents.groups" :key="name">
                        <template v-if="hasComponents(name)">
                            <h4 :class="{'pt-3' : index > 0}">{{group.name}}</h4>
                            <div>
                                <template v-for="(component, cName, cIndex) in getComponents(name)" :key="cName">
                                    <button @click="addComponent(component, cName)"
                                            class="btn btn-secondary">{{component.name}}
                                        <br><sub>{{component.description}}</sub></button>
                                </template>
                            </div>
                        </template>
                    </template>
                </div>

                <div class="modal-body motor-cms-component-form d-none">
                    <div class="row">
                        <div class="component-body" :class="[form.options.mediapool ? 'col-md-8' : 'col-md-12']">
                            <template v-for="field of form.fields" :key="field.options?.real_name">
                                <template v-if="field.type == 'hidden'">
                                    <input type="hidden" v-model="field.options.value" :name="field.options.real_name">
                                </template>
                                <template v-if="field.type == 'select'">

                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label }}</label>
                                        <select v-model="field.options.selected" :name="field.options.real_name"
                                                :id="field.options.real_name" class="form-control">
                                            <option v-if="field.options.empty_value">{{field.options.empty_value}}</option>
                                            <option v-for="(optName, optValue) in field.options.choices" :key="optValue" :value="optValue">
                                                {{optName}}
                                            </option>
                                        </select>
                                    </div>

                                </template>
                                <template v-if="field.type == 'text'">

                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label
                                            }}</label>
                                        <input :id="field.options.real_name" class="form-control" type="text"
                                               v-model="field.options.value" :name="field.options.real_name">
                                    </div>

                                </template>
                                <template v-if="field.type == 'checkbox'">

                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label
                                            }}</label>
                                        <input :id="field.options.real_name" class="form-control" type="checkbox"
                                               v-model="field.options.value" :name="field.options.real_name">
                                    </div>

                                </template>
                                <template v-if="field.type == 'htmleditor'">
                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label
                                            }}</label>
                                        <ckeditor :config="editorConfig" :editor="editor" :id="field.options.real_name"
                                                  v-model="field.options.value"></ckeditor>
                                    </div>
                                </template>
                                <template v-if="field.type == 'textarea'">
                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label
                                            }}</label>
                                        <textarea :id="field.options.real_name" class="form-control"
                                                  v-model="field.options.value"
                                                  :name="field.options.real_name"></textarea>
                                    </div>
                                </template>
                                <template v-if="field.type == 'datepicker'">
                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label
                                            }}</label>
                                        <input type="datetime-local" :id="field.options.real_name" class="form-control"
                                               v-model="field.options.value"
                                               :name="field.options.real_name">
                                    </div>
                                </template>
                                <template v-if="field.type == 'file_association'">
                                    <motor-backend-file-association-field v-model="field.options.value"
                                                                          :options="field.options"></motor-backend-file-association-field>
                                </template>
                            </template>
                        </div>
                        <div v-if="form.options.mediapool" class="col-md-4">
                            <motor-media-mediapool :component-modal="true"></motor-media-mediapool>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none">
                    <button type="button" class="btn btn-primary" @click="saveComponent">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<style lang="scss">
    .motor-cms-components button {
        width: 200px;
    }
</style>

<script setup>
import { ref, reactive, onMounted, onUnmounted, getCurrentInstance } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const props = defineProps(['pageId', 'pageVersionId', 'availableComponents']);

const { proxy, appContext } = getCurrentInstance();
const $t = proxy.$t;
const route = appContext.config.globalProperties.route;
const eventBus = window.eventBus;

const editor = ClassicEditor;
const editorConfig = {
    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
};

const componentContainer = ref('');
const form = reactive({
    fields: [],
    options: [],
    route: false,
    method: false,
    componentId: null,
});

function getComponents(group) {
    let components = {};
    for (let key in props.availableComponents.components) {
        if (props.availableComponents.components.hasOwnProperty(key)) {
            if (props.availableComponents.components[key].group == group) {
                components[key] = props.availableComponents.components[key];
            }
        }
    }
    return components;
}

function hasComponents(group) {
    for (let key in props.availableComponents.components) {
        if (props.availableComponents.components.hasOwnProperty(key)) {
            if (props.availableComponents.components[key].group == group) {
                return true;
            }
        }
    }
    return false;
}

function closeModal() {
    // Send clear event to all components to remove data in case the component gets reused
    form.fields = [];
    form.options = [];
    form.route = false;
    form.method = false;
    form.componentId = null;
    eventBus.emit('motor-cms:clear-data');
    $('#motor-component-modal').modal('hide');
}

function openModal(data) {
    $('.motor-cms-components').removeClass('d-none');
    $('.motor-cms-component-form').addClass('d-none');
    $('.modal-footer').addClass('d-none');

    $('.motor-cms-components').data('container', data.container);

    console.log('new component for container ' + data.container);

    $('#motor-component-modal .modal-title').html('Add new component to container ' + data.container);
    componentContainer.value = data.container;
    $('#motor-component-modal').modal('show');
}

function addComponent(component, index) {
    if (component.route === undefined) {
        // This is a component without configuration or separate model
        axios.post(route('component.base.store'), {
            container: componentContainer.value,
            page_version_id: props.pageVersionId,
            page_id: props.pageId,
            name: component.name,
            component_name: index
        })
            .then((response) => {
                $('#motor-component-modal').modal('hide');
                eventBus.emit('motor-cms:update-components');
                $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);
            })
            .catch(function (error) {
                console.log(error);
            });

    } else {
        axios.get(route(component.route + '.create'))
            .then((response) => {
                form.options = response.data.options;
                form.fields = response.data.fields;
                form.route = response.data.route;

                $('.motor-cms-components').addClass('d-none');
                $('.motor-cms-component-form').removeClass('d-none');
                $('.modal-footer').removeClass('d-none');
            })
            .catch(function (error) {
                console.log(error);
            });
    }
}

function saveComponent() {
    if (form.route.indexOf('.store') != -1) {
        post();
    }
    if (form.route.indexOf('.update') != -1) {
        patch();
    }

    // Send clear event to all components to remove data in case the component gets reused
    eventBus.emit('motor-cms:clear-data');
}

function editComponent(data) {
    componentContainer.value = data.container;

    axios.get(route(data.route, data.componentId)).then((response) => {
        form.options = JSON.parse(JSON.stringify(response.data.options));
        form.fields = JSON.parse(JSON.stringify(response.data.fields));
        form.route = JSON.parse(JSON.stringify(response.data.route));
        form.componentId = data.componentId;

        $('.motor-cms-components').addClass('d-none');
        $('.motor-cms-component-form').removeClass('d-none');
        $('.modal-footer').removeClass('d-none');
        $('#motor-component-modal .modal-title').html('Edit component in container ' + data.container);
        $('#motor-component-modal').modal('show');
    });
}

function buildFormData() {
    let data = {};

    for (let field of form.fields) {
        if (field.type === 'select') {
            data[field.options.real_name] = field.options.selected;
        } else if (field.type === 'file_association') {
            data[field.options.real_name] = field.options.value;
            data[field.options.real_name + '_position'] = field.options.position;
            data[field.options.real_name + '_enlarge'] = field.options.enlarge;
            data[field.options.real_name + '_description'] = field.options.description;
            data[field.options.real_name + '_crop'] = field.options.crop;
        } else {
            data[field.options.real_name] = field.options.value;
        }
    }

    data.page_version_id = props.pageVersionId;
    data.container = componentContainer.value;

    return data;
}

function post() {
    let data = buildFormData();

    axios.post(route(form.route), data)
        .then((response) => {
            closeModal();
            eventBus.emit('motor-cms:update-components');
            $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);
        })
        .catch(function (error) {
            console.log(error);
        });
}

function patch() {
    let data = buildFormData();

    axios.patch(route(form.route, form.componentId), data)
        .then((response) => {
            closeModal();
            eventBus.emit('motor-cms:update-components');
            $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);
        })
        .catch(function (error) {
            console.log(error);
        });
}

function deleteComponentHandler(data) {
    if (!confirm($t('motor-cms.backend.pages.delete_component_question'))) {
        return false;
    }

    axios.delete(route('backend.pages.components.delete', [data.pageId, data.componentId])).then((response) => {
        eventBus.emit('motor-cms:update-components');
        $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);
    });
}

function onOpenModal(data) {
    openModal(data);
}

function onEditComponent(data) {
    editComponent(data);
}

function onDeleteComponent(data) {
    deleteComponentHandler(data);
}

onMounted(() => {
    eventBus.on('motor-cms:open-modal', onOpenModal);
    eventBus.on('motor-cms:edit-component', onEditComponent);
    eventBus.on('motor-cms:delete-component', onDeleteComponent);
    $('#motor-component-modal').modal({ focus: false, show: false });
});

onUnmounted(() => {
    eventBus.off('motor-cms:open-modal', onOpenModal);
    eventBus.off('motor-cms:edit-component', onEditComponent);
    eventBus.off('motor-cms:delete-component', onDeleteComponent);
});
</script>

<style lang="scss">
    .ck-balloon-panel {
        z-index: 5000 !important;
    }
    .ck-editor__editable_inline {
        min-height: 300px;
    }
    /* Important part */
    .modal-dialog {
        overflow-y: initial !important
    }
    .modal-body .component-body {
        height: 70vh;
        overflow-y: auto;
    }
</style>
