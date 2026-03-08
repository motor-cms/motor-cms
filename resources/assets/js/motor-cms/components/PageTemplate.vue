<template>
    <motor-cms-page-template-sections :page-id="pageId" :template-data="templateData" :available-components="availableComponents"></motor-cms-page-template-sections>
</template>

<script setup>
import { watch, onMounted, onUnmounted, getCurrentInstance } from 'vue';
import { usePageComponentStore } from '../page-component-store';

const props = defineProps(['templateData', 'availableComponents', 'pageId']);

const store = usePageComponentStore();
const eventBus = window.eventBus;

const { appContext } = getCurrentInstance();
const route = appContext.config.globalProperties.route;

watch(() => store.triggerUpdate, () => {
    saveAllComponents();
});

function getComponents(pageId) {
    axios.get(route('backend.pages.component_data.read', pageId))
        .then(response => {
            store.setPageComponents(response.data);
        });
}

function saveAllComponents() {
    console.log('Save all components');
    axios.patch(route('backend.pages.component_data.update', props.pageId), store.pageComponents)
        .then(response => {
            console.log('All components saved');
        });
}

function onUpdateComponents() {
    if (props.pageId != null) {
        getComponents(props.pageId);
        console.log('Components will be updated');
    }
}

function onSaveAllComponents() {
    saveAllComponents();
}

onMounted(() => {
    eventBus.on('motor-cms:update-components', onUpdateComponents);
    eventBus.on('motor-cms:save-all-components', onSaveAllComponents);

    if (props.pageId != null) {
        getComponents(props.pageId);
    }
});

onUnmounted(() => {
    eventBus.off('motor-cms:update-components', onUpdateComponents);
    eventBus.off('motor-cms:save-all-components', onSaveAllComponents);
});
</script>

<style lang="scss">
</style>
