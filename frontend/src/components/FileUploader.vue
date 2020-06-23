<template>
  <section>
    <b-field label="ProjectName">
      <b-input v-model="projectName"></b-input>
    </b-field>
    <b-field>
      <b-upload name="files" @input="checkFiles()" v-model="dropFile" drag-drop expanded>
        <section class="section">
          <div class="content has-text-centered">
            <p>
              <b-icon icon="upload" size="is-large"> </b-icon>
            </p>
            <p>Drop your SVG-File here or click to upload</p>
          </div>
        </section>
      </b-upload>
    </b-field>

    <div class="tags" v-if="dropFile">
      <span
        class="tag is-primary"
      >
        {{ dropFile.name }}
        <button
          class="delete is-small"
          type="button"
          @click="deleteDropFile()"
        ></button>
      </span>
    </div>
    <svg-container :file=file v-on:updateLinkList="updateLinkList"></svg-container>


    <div class="field is-grouped m-t-md is-pulled-right">
      <div class="control">
        <button @click="submit()" class="button is-link">Submit</button>
      </div>
      <div class="control">
        <button class="button is-link is-light">Back</button>
      </div>
    </div>
    <div class="is-clearfix"></div>
  </section>
</template>

<script>
  import SvgContainer from "@/components/SvgContainer";

export default {
  components: {SvgContainer},
  data() {
    return {
      dropFile: null,
      file: null,
      projectName: ''
    };
  },
  methods: {
    submit() {
        let formData = new FormData();
        for(let i = 0; i < this.dropFile.length; i++ ) {
          let file = this.dropFile[i];
          formData.append('files[' + i + ']', file);
        }
        this.$http.post('/api/projects', formData, {
          headers: {
            'x-project-title' : this.projectName
          }
        }
        ).then(response => console.log(response));
    },
    deleteDropFile() {
      this.dropFile = null;
      this.file = '';
    },
    checkFiles() {
      const reader = new FileReader();
      reader.readAsText(this.dropFile);
      reader.onload = e => this.file = e.target.result;
    },
    updateLinkList(list) {
      console.log(list);
    }
  },
};
</script>
