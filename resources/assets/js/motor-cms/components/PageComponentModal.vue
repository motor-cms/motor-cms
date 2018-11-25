<template>
    <div id="motor-component-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button class="close" type="button" @click="closeModal()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body motor-cms-components d-none">
                    <template v-for="(group, name) in availableComponents.groups">
                        <h4>{{group.name}}</h4>
                        <template v-for="(component, index) in availableComponents.components">
                            <button v-if="component.group == name" @click="addComponent(component, index)"
                                    class="btn btn-secondary">{{component.name}}
                                <br><sub>{{component.description}}</sub></button>
                        </template>
                    </template>
                </div>
                <div class="modal-body motor-cms-component-form d-none">
                    <div class="row">
                        <div :class="[form.options.mediapool ? 'col-md-8' : 'col-md-12']">
                            <template v-for="field of form.fields">
                                <template v-if="field.type == 'hidden'">
                                    <input type="hidden" v-model="field.options.value" :name="field.options.real_name">
                                </template>
                                <template v-if="field.type == 'select'">

                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label }}</label>
                                        <select v-model="field.options.selected" :name="field.options.real_name"
                                                :id="field.options.real_name" class="form-control">
                                            <option v-for="(name, value) in field.options.choices" :value="value">
                                                {{name}}
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
                                <template v-if="field.type == 'htmleditor'">
                                    <div class="form-group">
                                        <label :for="field.options.real_name" class="control-label">{{
                                            field.options.label
                                            }}</label>
                                        <ckeditor type="classic" :id="field.options.real_name"
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
                                        <date-picker :id="field.options.real_name" class="form-control"
                                                     v-model="field.options.value"
                                                     :name="field.options.real_name" :config="{}"></date-picker>
                                    </div>
                                </template>
                                <template v-if="field.type == 'file_association'">
                                    <motor-backend-file-association-field v-model="field.options.value"
                                                            :options="field.options"></motor-backend-file-association-field>
                                </template>
                            </template>
                        </div>
                        <div v-if="form.options.mediapool" class="col-md-4">
                            <motor-media-mediapool></motor-media-mediapool>
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

<script>
    import datePicker from 'vue-bootstrap-datetimepicker';

    import {Ziggy} from 'ziggy';
    import route from 'ziggy/src/js/route';

    window.Ziggy = Ziggy;

    Vue.mixin({
        methods: {
            route: route
        }
    });


    export default {
        name: 'motor-cms-page-component-modal',
        props: ['pageId', 'pageVersionId', 'availableComponents'],
        components: {
            datePicker
        },
        data() {
            return {
                componentContainer: '',
                form: {
                    fields: [],
                    options: [],
                    route: false,
                    method: false,
                    componentId: null,
                }
            }
        },
        created: function () {
            this.$eventHub.$on('motor-cms:open-modal', (data) => {
                this.openModal(data);
            });
            this.$eventHub.$on('motor-cms:edit-component', (data) => {
                this.editComponent(data.route, data.componentId, data.container);
            });
            this.$eventHub.$on('motor-cms:delete-component', (data) => {
                this.deleteComponent(data.pageId, data.componentId);
            });
        },
        mounted: function () {
        },
        methods: {
            closeModal() {
                // Send clear event to all components to remove data in case the component gets reused
                this.$eventHub.$emit('motor-cms:clear-data');
                $('#motor-component-modal').modal('hide');
            },
            openModal(data) {
                $('.motor-cms-components').removeClass('d-none');
                $('.motor-cms-component-form').addClass('d-none');
                $('.modal-footer').addClass('d-none');

                $('.motor-cms-components').data('container', data.container);

                console.log('new component for container ' + data.container);

                $('#motor-component-modal').modal();
                $('#motor-component-modal .modal-title').html('Add new component to container ' + data.container);
                this.componentContainer = data.container;
            },
            addComponent(component, index) {
                if (component.route === undefined) {
                    // This is a component without configuration or separate model
                    axios.post(route('component.base.store'), {
                        container: this.componentContainer,
                        page_version_id: this.pageVersionId,
                        page_id: this.pageId,
                        name: component.name,
                        component_name: index
                    })
                        .then((response) => {

                            $('#motor-component-modal').modal('hide');
                            this.$eventHub.$emit('motor-cms:update-components');
                            $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);

                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                } else {
                    axios.get(route(component.route + '.create'))
                        .then((response) => {

                            this.form.options = response.data.options;
                            this.form.fields = response.data.fields;
                            this.form.route = response.data.route;

                            $('.motor-cms-components').addClass('d-none');
                            $('.motor-cms-component-form').removeClass('d-none');
                            $('.modal-footer').removeClass('d-none');

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            saveComponent() {
                if (this.form.route.indexOf('.store') != -1) {
                    this.post();
                }
                if (this.form.route.indexOf('.update') != -1) {
                    this.patch();
                }

                // Send clear event to all components to remove data in case the component gets reused
                this.$eventHub.$emit('motor-cms:clear-data');

            },
            editComponent: function (routeString, componentId, container) {

                this.componentContainer = container;

                axios.get(route(routeString, componentId)).then((response) => {

                    this.form.options = response.data.options;
                    this.form.fields = response.data.fields;
                    this.form.route = response.data.route;
                    this.form.componentId = componentId;

                    $('#motor-component-modal').modal();
                    $('.motor-cms-components').addClass('d-none');
                    $('.motor-cms-component-form').removeClass('d-none');
                    $('.modal-footer').removeClass('d-none');
                    $('#motor-component-modal .modal-title').html('Edit component in container ' + container);

                });
            },
            post: function () {

                let that = this;
                let data = {};

                for (let field of that.form.fields) {
                    if (field.type == 'select') {
                        data[field.options.real_name] = parseInt(field.options.selected);
                    } else {
                        data[field.options.real_name] = field.options.value;
                    }
                }

                data.page_version_id = that.pageVersionId;
                data.container = this.componentContainer;

                axios.post(route(this.form.route), data)
                    .then((response) => {
                        $('#motor-component-modal').modal('hide');
                        this.$eventHub.$emit('motor-cms:update-components');
                        $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);

                    })
                    .catch(function (error) {
                        console.log(error);
                    })

            },
            patch: function () {
                let that = this;
                let data = {};

                for (let field of that.form.fields) {
                    if (field.type == 'select') {
                        data[field.options.real_name] = parseInt(field.options.selected);
                    } else {
                        data[field.options.real_name] = field.options.value;
                    }
                }

                data.page_version_id = that.pageVersionId;
                data.container = this.componentContainer;

                axios.patch(route(this.form.route, this.form.componentId), data)
                    .then((response) => {
                        $('#motor-component-modal').modal('hide');
                        this.$eventHub.$emit('motor-cms:update-components');
                        $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);

                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            deleteComponent: function (pageId, componentId) {

                if (!confirm(this.$t('motor-cms.backend.pages.delete_component_question'))) {
                    // if (!confirm('{{trans('motor-cms::backend/pages.delete_component_question')}}')) {
                    return false;
                }

                axios.delete(route('backend.pages.components.delete', [pageId, componentId])).then((response) => {
                    this.$eventHub.$emit('motor-cms:update-components');
                    $('.motor-cms-component-flash').html(response.data.message).removeClass('d-none').css('display', '').delay(3000).fadeOut(350);
                });
            }
        },
    }
</script>


<style lang="scss">
</style>