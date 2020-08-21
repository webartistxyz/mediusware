<template>
  <span>
    <list-data
      ref="refresh_list"
      :url="url"
      :headers="headers"
      :others_query="others_query"
      tableSort="buffer_postings.id"
    >
      <template slot="table_filters">
        <div class="col-md-3">
          <datepicker
            v-model="others_query.filter_date"
            placeholder="From"
            :highlighted="highlighted"
            format="yyyy-MM-dd"
            @input="formatDate()"
          ></datepicker>
        </div>
        <select-box
          ref="select_group"
          placeholder="Select group"
          divClass="col-md-3"
          :useLabel="false"
          v-model="group_data"
          @input="setGroupId()"
        ></select-box>
      </template>
      <template slot="table_data" slot-scope="{ data }">
        <td>{{ data.group_name }}</td>
        <td>{{ data.group_type }}</td>
        <td>{{ data.user_name }}</td>
        <td>{{ data.post_text }}</td>
        <td>{{ data.sent_at }}{{ " (" + data.timezone + ")" }}</td>
      </template>
    </list-data>
  </span>
</template>
<script>
import ListData from "../../components/ListData/List";
import SelectBox from "../../components/SelectBox/SelectBox";
import moment from "moment";
export default {
  name: "list-history",
  components: { ListData, SelectBox },
  data() {
    return {
      url: "list-history",
      others_query: {},
      group_data: null,
      highlighted: {
        customPredictor: (date) => {
          let now = new Date();
          if (date.getDate() === now.getDate()) {
            return true;
          }
        },
      },
      headers: [
        { title: "Group Name", name: "group_name", sort: true },
        { title: "Group Type", name: "group_type", sort: true },
        { title: "Account Name", name: "user_name", sort: true },
        { title: "Post Text", name: "post_text", sort: true },
        { title: "Time", name: "sent_at", sort: true },
      ],
    };
  },
  methods: {
    formatDate() {
      this.others_query.filter_date = moment(
        this.others_query.filter_date
      ).format("YYYY-MM-DD");

      this.$refs.refresh_list.perPgeQuery("list-history");
    },
    setGroupId() {
      //console.log(this.group_data.id);

      this.group_data
        ? (this.others_query.group_id = this.group_data.id)
        : (this.others_query.group_id = "");
      this.$refs.refresh_list.perPgeQuery("list-history");
    },
    getAllGroups() {
      axios.post("/get_all_group").then((response) => {
        // this.allGroups = response.data;

        this.$refs.select_group.dataList = response.data;
        //console.log(response.data);
      });
    },
  },
  created() {
    this.getAllGroups();
  },
};
</script>
