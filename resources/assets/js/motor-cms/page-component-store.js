
const swapArrayElements = (arr, x, y) => {
    if (arr[x] === undefined || arr[y] === undefined) {
        return arr
    }
    const a = x > y ? y : x
    const b = x > y ? x : y
    return [
        ...arr.slice(0, a),
        arr[b],
        ...arr.slice(a+1, b),
        arr[a],
        ...arr.slice(b+1)
    ]
};

export default {
    namespaced: true,
    state: {
        pageId: null,
        availableComponents: [],
        pageComponents: [],
        templateData: [],
        triggerUpdate: 0,
    },
    getters: {
        pageComponentsByContainer: (state) => (container) => {
            if (state.pageComponents[container] === undefined) {
                return [];
            }
            return state.pageComponents[container];
        }
    },
    mutations: {
        setPageComponents(state, payload) {
            Vue.set(state, 'pageComponents', payload);
            // state.pageComponents = payload;
        },
        setAvailableComponents(state, payload) {
            Vue.set(state, 'availableComponents', payload);
            // state.pageComponents = payload;
        },
        setTemplateData(state, payload) {
            Vue.set(state, 'templateData', payload);
            // state.pageComponents = payload;
        },
        sortComponent(state, payload) {
            console.log('Sort component');

            if (payload.sourceContainer !== payload.targetContainer) {
                console.log("Container not identical - will not sort");
                return;
            }

            if (payload.event.from === payload.event.to) {
                console.log('Sorting within the same container');
                let component = JSON.parse(JSON.stringify(state.pageComponents[payload.sourceContainer][payload.oldIndex]));

                let newComponentOrder = JSON.parse(JSON.stringify(state.pageComponents[payload.sourceContainer]));
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
                state.pageComponents[payload.sourceContainer] = [];
                setTimeout( () => {
                    let newComponents = [];
                    for (let c of newComponentOrder) {
                        newComponents.push(JSON.parse(JSON.stringify(c)));
                    }
                    state.pageComponents[payload.sourceContainer] = newComponents;
                    state.triggerUpdate++;
                    console.log("Trigger update");
                    // this.$eventHub.$emit('motor-cms:save-all-components');
                }, 250);
            } else {
                console.log('Sorting within different containers - do nothing');
            }
        },
        moveComponent(state, payload) {
            console.log("Move component container");

            // Check if there is already a component inside the target container
            if (state.pageComponents[payload.targetContainer] === undefined) {
                state.pageComponents[payload.targetContainer] = [];
            }

            // Move the source component in the target container
            let component = JSON.parse(JSON.stringify(state.pageComponents[payload.sourceContainer][payload.index]));

            component.page_component_data.container = payload.targetContainer;
            component.page_component_data.sort_position = payload.newIndex;

            // Insert component to correct index
            state.pageComponents[payload.targetContainer].splice(payload.newIndex, 0, component);

            // Write new sort_positions
            let count = 1;
            for (let c of state.pageComponents[payload.targetContainer]) {
                c.page_component_data.sort_position = count;
                count++;
            }

            // Remove component from source
            let oldComponents = JSON.parse(JSON.stringify(state.pageComponents[payload.sourceContainer]));
            oldComponents.splice(payload.oldIndex, 1);

            // Write new sort_positions
            count = 1;
            for (let c of oldComponents) {
                c.page_component_data.sort_position = count;
                count++;
            }

            // Somehow some components are moving together with the actual source component if the source-container contains more than one component
            // We're fixing it by completely emptying the container and adding a small timeout before adding the items again
            state.pageComponents[payload.sourceContainer] = [];
            setTimeout( () => {
                for (let c of oldComponents) {
                    state.pageComponents[payload.sourceContainer].push(c);
                }
                state.triggerUpdate++;
                console.log("Trigger update");
                // this.$eventHub.$emit('motor-cms:save-all-components');
            }, 250);
        }
    }
};