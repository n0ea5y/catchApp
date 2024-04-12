
//店舗マッピング
export function shopMapping (storeList, storeId)  {
    const test = storeList.find(function (item) {
        return item.value === storeId;
    });
    return test.title;
}
