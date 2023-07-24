import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

export const getItemInfo = async (id) => {
    const response = await axios.get('http://project-php:8081/server/item.php?id=' + id);
    return response.data;
}
export const getSize = async (name) => {
    const response = await axios.get('http://project-php:8081/server/getItemSizes.php?name=' + name);
    return response.data;
}

export const postComment = async (userID, itemName, rating, comment, recommend) => {
    const data = {
        userID,
        itemName,
        rating,
        comment,
        recommend
    };
    const response = await axios.post("http://project-php:8081/server/addComment.php", JSON.stringify(data), {
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        }
    });

    return response.data;
}
export const getComment = async (item_name) => {
    const response = await axios.get('http://project-php:8081/server/getComments.php?name=' + item_name);
    return response.data;
}