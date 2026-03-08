<template>
    <div>
        <template v-for="row in templateData" :key="row">
            <div class="row">
                <template v-for="element in row" :key="element.container || element.alias">
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
                                    <draggable
                                        :model-value="store.pageComponentsByContainer(element.container)"
                                        group="components"
                                        handle=".handle"
                                        :sort="true"
                                        drag-class="sortable-drag"
                                        ghost-class="sortable-ghost"
                                        :item-key="(item) => item.page_component_data?.id || item._uid || crypto.randomUUID()"
                                        @sort="onSort"
                                        @start="onStart"
                                        @end="onEnd"
                                        @add="onAdd"
                                        class="clearfix mb-1"
                                        style="min-height: 50px;">
                                        <template #item="{ element: component, index }">
                                            <div :data-index="index" :data-container="element.container">
                                                <button @click="deleteComponent(component.page_component_data.id, $event)"
                                                        class="motor-component-delete btn btn-sm btn-danger pull-right float-right">
                                                    <i class="fa fa-trash"></i></button>
                                                <button v-if="availableComponents.components[component.component_slug]?.route !== undefined" @click="editComponent(availableComponents.components[component.page_component_data.component_name].route+'.edit', component.page_component_data.component_id, element.container, $event)"
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

<script setup>
import { onMounted, onUnmounted } from 'vue';
import draggable from 'vuedraggable';
import { usePageComponentStore } from '../page-component-store';

const props = defineProps(['templateData', 'availableComponents', 'pageId']);
const store = usePageComponentStore();
const eventBus = window.eventBus;

function onStart(e) {
    eventBus.emit('component:drag:start', true);
}

function onEnd(e) {
    eventBus.emit('component:drag:end', true);
}

function onAdd(e) {
    store.moveComponent({
        sourceContainer: e.clone.dataset.container,
        targetContainer: e.target.parentNode.dataset.container,
        index: e.clone.dataset.index,
        oldIndex: e.oldIndex,
        newIndex: e.newIndex
    });
}

function onSort(e) {
    store.sortComponent({
        event: e,
        sourceContainer: e.clone.dataset.container,
        targetContainer: e.target.parentNode.dataset.container,
        index: e.clone.dataset.index,
        oldIndex: e.oldIndex,
        newIndex: e.newIndex
    });
}

function openModal(container, e) {
    e.preventDefault();
    eventBus.emit('motor-cms:open-modal', { container: container });
}

function deleteComponent(componentId, e) {
    e.preventDefault();
    eventBus.emit('motor-cms:delete-component', { pageId: props.pageId, componentId: componentId });
}

function editComponent(routeString, componentId, container, e) {
    e.preventDefault();
    eventBus.emit('motor-cms:edit-component', {
        route: routeString,
        componentId: componentId,
        container: container
    });
}
</script>

<style lang="scss">
</style>
