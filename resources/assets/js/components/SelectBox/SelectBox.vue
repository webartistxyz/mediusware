<template>
  <div :class="divClass" :style="selectStyle">
    <div class="form-group" :class="innerDivClass">
      <label v-if="useLabel">
        <slot name="label"></slot>
      </label>
      <v-select
        inputId="select_height"
        :options="dataList"
        :label="selectLabel"
        :placeholder="placeholder"
        :filterable="filterable"
        :value="value"
        v-bind="$attrs"
        v-on="{...$listeners, $listeners: event => $emit('input', event.target.value)}"
      >
        <!-- <template slot="option" slot-scope="option">
                    <span :class="option.icon"></span>
                    {{ option.title }}
        </template>-->
      </v-select>
      <span class="help-block">
        <slot name="error"></slot>
      </span>
    </div>
  </div>
</template>
<script>
export default {
  name: "select_box",
  props: {
    value: {
      default: "",
      timeout: null
    },
    divClass: {
      type: String,
      default: ""
    },
    innerDivClass: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    selectLabel: {
      type: String,
      default: "name"
    },
    selectStyle: {
      type: String,
      default: ""
    },
    useLabel: {
      type: Boolean,
      default: true
    },
    filterable: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      dataList: [],
      timeout: null
    };
  },
  methods: {
    getDataList(url) {
      axios.get(url).then(response => {
        this.dataList = response.data;
      });
    },
    getDataBySearch(url, searchTerm, loading) {
      if (searchTerm.searchTerm.trim() != "") {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => {
          loading(true);
          axios
            .post(url, { searchTerm })
            .then(response => {
              loading(false);
              this.dataList = response.data;
              //console.log(response.data);
            })
            .catch(error => {
              loading(false);
            });
        }, 1000);
      }
    }
  }
};
</script>
