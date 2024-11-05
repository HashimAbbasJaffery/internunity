import { onMounted, ref, watchEffect, toValue } from "vue";
import axios from "axios";

export default function useFetch(url, old_data = []) {
    const internshipsData = ref(old_data);
    const is_loading = ref(true);
    const is_loading_more = ref(true);
    const next = ref();


    const fetchData = () => {
        is_loading_more.value = true;
        axios.get(toValue(url))
            .then(res => {
                internshipsData.value.push(...res.data.data);
                next.value = res.data.links[res.data.links.length - 1].url;
            })
            .catch(err => {
                console.log(err)
            })
            .finally(() => {
                is_loading.value = false
                is_loading_more.value = false;
            })
    }

    watchEffect(() => {
        fetchData();
    })

    return { internshipsData, is_loading, is_loading_more, next };

}
