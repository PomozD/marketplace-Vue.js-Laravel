import axios from "axios";

export const order = async (userID, itemID, count, numberOrder) => {
    const data = {
        userID,
        itemID,
        count,
        numberOrder
    };
    const response = await axios.post("http://project-php:8081/server/orders.php", JSON.stringify(data), {
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        }
    });
    return response.data;
}