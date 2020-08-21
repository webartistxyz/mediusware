<template>
  <list-data ref="refresh_list" :url="url" :headers="headers">
    <template slot="table_data" slot-scope="{ data }">
      <td>{{ data.group_name }}</td>
      <td>{{ data.group_type }}</td>
      <td>{{ data.user_name }}</td>
      <td>{{ data.post_text }}</td>
      <td>{{ data.sent_at }}{{ data.timezone }}</td>
    </template>
  </list-data>
</template>
<script>
export default {
  name: "list-history",
  data() {
    return {
      url: "list-history",
      headers: [
        { title: "Group Name", name: "group_name", sort: true },
        { title: "Group Type", name: "group_type", sort: true },
        { title: "Account Name", name: "user_name", sort: true },
        { title: "Post Text", name: "post_text", sort: true },
        { title: "Time", name: "sent_at", sort: true },
      ],
    };
  },
};
</script>
