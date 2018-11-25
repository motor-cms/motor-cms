<template>
    <div>
        <template v-for="row in templateData">
            <div class="row">
                <template v-for="element in row">
                    <div class="motor-template-section"
                         :class="[element.class ? element.class : '', 'col-md-'+element.width]">
                        <template v-if="element.items">
                            <motor-cms-page-template-sections :page-id="pageId" :template-data="element.items"
                                               :available-components="availableComponents"></motor-cms-page-template-sections>
                        </template>
                        <template v-if="!element.items">
                            <div class="card">
                                <h5 class="card-header clearfix">
                                    {{element.alias}}
                                    <button :data-container="element.container"
                                            class="btn btn-sm btn-primary float-right"
                                            @click="openModal(element.container, $event)"><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </h5>
                                <div class="card-body" :data-container="element.container">
                                        <draggable :options="{group:{ name:'components'}, handle: '.handle', sort: true, dragClass: 'sortable-drag', ghostClass: 'sortable-ghost'}"
                                                   @sort="onSort" @start="onStart" @end="onEnd" @add="onAdd" class="clearfix mb-1" style="min-height: 50px;">
                                            <template v-if="$store.getters['pageComponentStore/pageComponentsByContainer'](element.container).length > 0" v-for="(component, index) in $store.getters['pageComponentStore/pageComponentsByContainer'](element.container)">
                                                <div :data-index="index" :data-container="element.container">
                                                    <button @click="deleteComponent(component.page_component_data.id, $event)"
                                                            class="motor-component-delete btn btn-sm btn-danger pull-right float-right">
                                                        <i class="fa fa-trash"></i></button>
                                                    <button v-if="availableComponents.components[component.page_component_data.component_name].route !== undefined" @click="editComponent(availableComponents.components[component.page_component_data.component_name].route+'.edit', component.page_component_data.component_id, element.container, $event)"
                                                            class="motor-component-edit btn btn-sm btn-warning pull-right float-right">
                                                        <i class="fa fa-edit"></i></button>
                                                    <button class="motor-component-move btn btn-sm btn-primary pull-right float-right handle">
                                                        <i class="fas fa-arrows-alt"></i></button>
                                                    <strong>{{component.component_name}}</strong>
                                                    <p>
                                                        {{component.preview}}
                                                    </p>
                                                </div>
                                            </template>
                                        </draggable>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </template>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';

    export default {
        props: ['templateData', 'availableComponents', 'pageId'],
        name: 'motor-cms-template-sections',
        components: {
            draggable,
        },
        created: function () {
        },
        mounted: function () {
        },
        methods: {
            onStart: function (e) {
                this.$eventHub.$emit('component:drag:start', true);
            },
            onEnd: function (e) {
                this.$eventHub.$emit('component:drag:end', true);
            },
            onAdd: function(e) {
                this.$store.commit('pageComponentStore/moveComponent', {sourceContainer: e.clone.dataset.container, targetContainer: e.target.parentNode.dataset.container, index: e.clone.dataset.index, oldIndex: e.oldIndex, newIndex: e.newIndex});
            },
            onSort: function(e) {
                this.$store.commit('pageComponentStore/sortComponent', {event: e, sourceContainer: e.clone.dataset.container, targetContainer: e.target.parentNode.dataset.container, index: e.clone.dataset.index, oldIndex: e.oldIndex, newIndex: e.newIndex});
            },
            openModal(container, e) {
                e.preventDefault();
                this.$eventHub.$emit('motor-cms:open-modal', {container: container})
            },
            deleteComponent(componentId, e) {
                e.preventDefault();
                this.$eventHub.$emit('motor-cms:delete-component', {pageId: this.pageId, componentId: componentId})
            },
            editComponent(routeString, componentId, container, e) {
                e.preventDefault();
                this.$eventHub.$emit('motor-cms:edit-component', {
                    route: routeString,
                    componentId: componentId,
                    container: container
                })
            },
        }
    }
</script>


<style lang="scss">
</style>
