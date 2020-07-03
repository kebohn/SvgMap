<template>
    <div class="listContainer">
        <b-table
                :data="projects"
                :columns="columns"
                :selected.sync="selected"
                hoverable
                paginated pagination-position="top"
                per-page="50">
        </b-table>
        <div class="buttons p-t-lg" style="float: right">
            <b-button type="is-link" :disabled="!selected" icon-left="folder" @click="openProject">
                Open Project
            </b-button>
            <b-button type="is-link" :disabled="!selected" icon-left="trash" @click="confirmDeleteProject">
                Delete
            </b-button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                projects: [],
                selected: null,
                columns: [
                    {
                        field: 'name',
                        label: 'ProjectName',
                    }
                ]
            }
        },
        mounted: function () {
            this.fetchProjects();
        },
        methods: {
            fetchProjects() {
                this.$http.get('/api/projects').then(response => {
                    this.projects = response.data
                });
            },
            confirmDeleteProject() {
                this.$buefy.dialog.confirm({
                    title: 'Deleting Project',
                    message: `Are you sure you want to <b>delete Project ${this.selected.name}</b>? This action cannot be undone.`,
                    confirmText: 'Delete Project',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => {
                        this.deleteProject();
                    }
                })
            },
            deleteProject() {
                this.$http.delete(`/api/projects/${this.selected.id}`)
                    .then(response => {
                        if (response.status === 200) {
                            if (this.removeDeletedProjectFromArray()) {
                                this.$buefy.toast.open({
                                    message: 'Project deleted!',
                                    type: 'is-success'
                                });
                            }
                        } else {
                            this.$buefy.toast.open({
                                message: `Project could not be deleted!\n (${response.status})`,
                                type: 'is-danger'
                            });
                        }
                    })
                    .catch(error => {
                        this.$buefy.toast.open({
                            message: `An error occurred, please try again!\n ${error}`,
                            type: 'is-danger'
                        });
                    });
            },
            removeDeletedProjectFromArray() {
                let idx = this.projects.indexOf(this.selected);
                if (idx !== -1) {
                    this.projects.splice(idx, 1)
                    this.selected = null;
                    return true;
                }
                return false;
            },
            openProject() {
                this.$router.push({name: 'Project', params: {id: this.selected.id}})
            }
        }
    }
</script>
<style scoped>
</style>