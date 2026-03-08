import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

const swapArrayElements = (arr, x, y) => {
    if (arr[x] === undefined || arr[y] === undefined) {
        return arr;
    }
    const a = x > y ? y : x;
    const b = x > y ? x : y;
    return [
        ...arr.slice(0, a),
        arr[b],
        ...arr.slice(a + 1, b),
        arr[a],
        ...arr.slice(b + 1)
    ];
};

export const usePageComponentStore = defineStore('pageComponentStore', () => {
    const pageId = ref(null);
    const availableComponents = ref([]);
    const pageComponents = ref([]);
    const templateData = ref([]);
    const triggerUpdate = ref(0);

    function pageComponentsByContainer(container) {
        if (pageComponents.value[container] === undefined) {
            return [];
        }
        return pageComponents.value[container];
    }

    function setPageComponents(payload) {
        pageComponents.value = payload;
    }

    function setAvailableComponents(payload) {
        availableComponents.value = payload;
    }

    function setTemplateData(payload) {
        templateData.value = payload;
    }

    function sortComponent(payload) {
        console.log('Sort component');

        if (payload.sourceContainer !== payload.targetContainer) {
            console.log("Container not identical - will not sort");
            return;
        }

        if (payload.event.from === payload.event.to) {
            console.log('Sorting within the same container');
            let component = JSON.parse(JSON.stringify(pageComponents.value[payload.sourceContainer][payload.oldIndex]));

            let newComponentOrder = JSON.parse(JSON.stringify(pageComponents.value[payload.sourceContainer]));
            newComponentOrder.splice(payload.oldIndex, 1);

            // Insert component to correct index
            newComponentOrder.splice(payload.newIndex, 0, component);

            // Write new sort_positions
            let count = 1;
            for (let c of newComponentOrder) {
                c.page_component_data.sort_position = count;
                count++;
            }

            // Somehow some components are moving together with the actual source component if the source-container contains more than one component
            // We're fixing it by completely emptying the container and adding a small timeout before adding the items again
            pageComponents.value[payload.sourceContainer] = [];
            setTimeout(() => {
                let newComponents = [];
                for (let c of newComponentOrder) {
                    newComponents.push(JSON.parse(JSON.stringify(c)));
                }
                pageComponents.value[payload.sourceContainer] = newComponents;
                triggerUpdate.value++;
                console.log("Trigger update");
            }, 250);
        } else {
            console.log('Sorting within different containers - do nothing');
        }
    }

    function moveComponent(payload) {
        console.log("Move component container");

        // Check if there is already a component inside the target container
        if (pageComponents.value[payload.targetContainer] === undefined) {
            pageComponents.value[payload.targetContainer] = [];
        }

        // Move the source component in the target container
        let component = JSON.parse(JSON.stringify(pageComponents.value[payload.sourceContainer][payload.index]));

        component.page_component_data.container = payload.targetContainer;
        component.page_component_data.sort_position = payload.newIndex;

        // Insert component to correct index
        pageComponents.value[payload.targetContainer].splice(payload.newIndex, 0, component);

        // Write new sort_positions
        let count = 1;
        for (let c of pageComponents.value[payload.targetContainer]) {
            c.page_component_data.sort_position = count;
            count++;
        }

        // Remove component from source
        let oldComponents = JSON.parse(JSON.stringify(pageComponents.value[payload.sourceContainer]));
        oldComponents.splice(payload.oldIndex, 1);

        // Write new sort_positions
        count = 1;
        for (let c of oldComponents) {
            c.page_component_data.sort_position = count;
            count++;
        }

        // Somehow some components are moving together with the actual source component if the source-container contains more than one component
        // We're fixing it by completely emptying the container and adding a small timeout before adding the items again
        pageComponents.value[payload.sourceContainer] = [];
        setTimeout(() => {
            for (let c of oldComponents) {
                pageComponents.value[payload.sourceContainer].push(c);
            }
            triggerUpdate.value++;
            console.log("Trigger update");
        }, 250);
    }

    return {
        pageId,
        availableComponents,
        pageComponents,
        templateData,
        triggerUpdate,
        pageComponentsByContainer,
        setPageComponents,
        setAvailableComponents,
        setTemplateData,
        sortComponent,
        moveComponent,
    };
});
