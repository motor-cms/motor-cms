<template>
    <motor-cms-page-template-sections :page-id="pageId" :template-data="templateData" :available-components="availableComponents"></motor-cms-page-template-sections>
</template>

<script>
    import draggable from 'vuedraggable';
    import {Ziggy} from 'ziggy-js';
    import route from 'ziggy-js/src/js/route';

    window.Ziggy = Ziggy;

    Vue.mixin({
        methods: {
            route: route
        }
    });

    export default {
        props: ['templateData', 'availableComponents', 'pageId'],
        name: 'motor-cms-template',
        components: {
            draggable,
        },
        data() {
            return {
            }
        },
        created: function () {
        },
        computed: {
            triggerUpdate () {
                return this.$store.state.pageComponentStore.triggerUpdate;
            }
        },
        watch: {
            triggerUpdate (newValue, oldValue) {
                this.saveAllComponents();
            }
        },
        mounted: function () {
            this.$eventHub.$on('motor-cms:update-components', (data) => {
                if (this.pageId != null) {
                    this.getComponents(this.pageId);
                    console.log('Components will be updated');
                }
            });

            this.$eventHub.$on('motor-cms:save-all-components', () => {
                this.saveAllComponents();
            });

            if (this.pageId != null) {
                this.getComponents(this.pageId);
            }
        },
        methods: {
            getComponents: function (pageId) {
                axios.get(route('backend.pages.component_data.read', pageId))
                    .then(response => {
                        this.$store.commit('pageComponentStore/setPageComponents', response.data);
                    });
            },
            saveAllComponents() {
                console.log('Save all components');
                axios.patch(route('backend.pages.component_data.update', this.pageId), this.$store.state.pageComponentStore.pageComponents)
                    .then(response => {
                        console.log('All components saved');
                    });
            }

        }
    }
</script>


<style lang="scss">
</style>
