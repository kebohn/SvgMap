<template>
  <section>
    <div class="field is-grouped m-t-md is-pulled-right">
      <div class="control">
        <button @click="submit()" class="button is-link">Submit</button>
      </div>
      <div class="control">
        <button class="button is-link is-light">Back</button>
      </div>
    </div>
    <div class="is-clearfix"></div>

    <b-field label="ProjectName">
      <b-input v-model="projectName"></b-input>
    </b-field>
    <b-field>
      <div class="buttons">
          <b-button size="is-small"
                 v-for="(link, index) in links"
                 :key="index" v-bind:class="clicked === index ? 'is-warning' : 'is-danger'" @click="activateBtn(index)">
            {{link.getAttribute("xlink:title")}}
          </b-button>
      </div>
    </b-field>

    <b-field>
      <b-upload name="files" @input="checkFiles()" v-model="dropFiles" multiple drag-drop expanded>
        <section class="section">
          <div class="content has-text-centered">
            <p>
              <b-icon icon="upload" size="is-large"> </b-icon>
            </p>
            <p>Drop your File here or click to upload</p>
          </div>
        </section>
      </b-upload>
    </b-field>

    <div class="tags">
      <span
        v-for="(file, index) in dropFiles"
        :key="index"
        class="tag is-primary"
      >
        {{ file.name }}
        <button
          class="delete is-small"
          type="button"
          @click="deleteDropFile(index)"
        ></button>
      </span>
    </div>
    <svg-container :file=file v-on:updateLinkList="updateLinkList"></svg-container>
  </section>
</template>

<script>
  import SvgContainer from "@/components/SvgContainer";

export default {
  components: {SvgContainer},
  data() {
    return {
      dropFiles: [],
      file: null,
      projectName: '',
      links: [],
      clicked:''
    };
  },
  methods: {
    submit() {
        let formData = new FormData();
        for(let i = 0; i < this.dropFiles.length; i++ ) {
          let file = this.dropFiles[i];
          formData.append('files[' + i + ']', file);
        }
        this.$http.post('/api/projects', formData, {
          headers: {
            'x-project-title' : this.projectName
          }
        }
        ).then(response => console.log(response));
    },
    deleteDropFile(index) {
      if (this.getFileExtension(this.dropFiles[index].name) === 'svg') {
        this.dropFiles = [];
        this.file = null;
        this.links = [];
      } else {
        this.dropFiles.splice(index, 1);
      }
    },
    checkFiles() {
      for (let file of this.dropFiles) {
        if (this.getFileExtension(file.name) === 'svg') {
          const reader = new FileReader();
          reader.readAsText(file);
          reader.onload = e => this.file = e.target.result;
        }
      }
    },
    updateLinkList(list) {
      this.links = list;
    },
    activateBtn(e){
      this.clicked = e;
    },
    getFileExtension(file) {
      return file.split('.').pop().toLowerCase()
    }
  },
};
</script>
