
//店舗マッピング
export function shopMapping (storeList, storeId)  {
    if(!storeList || !storeId) return;

    const item = storeList.find(function (item) {
        return item.value === storeId;
    });
    return item.title;
}
