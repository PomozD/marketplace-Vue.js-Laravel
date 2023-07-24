import axios from "axios";

export const editComment = async (userID, itemName, rating, comment, recommend) => {
    const data = {
        userID,
        itemName,
        rating,
        comment,
        recommend
    };
    const response = await axios.post("http://project-php:8081/server/editComment.php", JSON.stringify(data), {
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        }
    });
    return response.data;
}

export const deleteComment = async (userID, itemName) => {
    const response = await axios.get(
        'http://project-php:8081/server/deleteComment.php?userID=' + userID + '&itemName=' + itemName);
    console.log(response.data);
    return response.data?.item;
}