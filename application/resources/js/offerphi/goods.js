class Goods {
    constructor(purpose = 'menu', entry = 50, methodType = 'get') {
        this.setPurpose(purpose);
        this.setEntry(entry);
        this.setMethodType(methodType);
    }

    setPurpose(purpose)
    {
        this.purpose = purpose;
    }
    setEntry(entry)
    {
        this.entry = entry;
    }
    setMethodType(methodType)
    {
        this.methodType = methodType;
    }

    getPurpose()
    {
        return this.purpose;
    }
    getEntry()
    {
        return this.entry;
    }
    getMethodType()
    {
        return this.methodType;
    }
    dataset(data)
    {
        let formData = new FormData;
        let purpose = this.getPurpose();
        formData.append('purpose', purpose);
        if (data) {
            for (let key in data) {
                formData.append(key, data[key]);
            }
        }
        return formData;
    }
    deleteCatalogList() {
        if (document.getElementById('delIdx')) {
            document.getElementById('delIdx').value = "";
        }
        if (document.getElementById('catalogName')) {
            document.getElementById('catalogName').value = "";
        }
        if (document.getElementById('catalogCode')) {
            document.getElementById('catalogCode').value = "";
        }

        if (document.getElementById('catalogList')) {
            let catalogList = document.getElementById('catalogList');
            while (catalogList.firstChild) {
                catalogList.removeChild(catalogList.firstChild);
            }
        }
    }
    setEventListener()
    {
        // 선택 checkbox 하나씩만 선택가능
        document.querySelectorAll("input[name='data-select']").forEach(function (el) {
            el.addEventListener('click', event => {
                if (event.target.checked === true) {
                    const checkedPay = document.querySelectorAll("input[name='data-select']:checked");
                    if (checkedPay) {
                        checkedPay.forEach(function (el) {
                            el.checked = false;
                        });
                    }
                    event.target.checked = true;
                }
            });
        });

        // 등록 Modal
        const regiGoods = document.getElementById("registerGoods");
        regiGoods.addEventListener('click', function (e) {
            document.querySelector("#goodsManage input[name='goodsManageType']").value = 'register';
            document.querySelector("#goodsManage #goodsModalTitle").innerHTML = "결제경로 신규 등록";
            document.querySelector("#goodsManage .regist-btn").innerHTML = "등록";

            const modalEl = document.querySelector("#goodsManage");
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });

        // 수정 Modal
        const editGoods = document.getElementById('editGoods');
        editGoods.addEventListener('click', function (e) {
            const idxTemp = document.querySelector("input[name='data-select']:checked");
            if (!idxTemp) {
                alert('수정대상이 선택되지 않았습니다.');
                return false;
            }
            let idx = idxTemp.getAttribute('data-value');
            Goods.prototype.setPurpose('searchGoodsEdit');
            Goods.prototype.setMethodType('get');
            let data = {
                'goodsManageIdx' : idx
            };
            Goods.prototype.request(data);
        });

        // 삭제 Modal
        const delGoods = document.getElementById('deleteGoods');
        delGoods.addEventListener('click', function (e) {
            const idxTemp = document.querySelector("input[name='data-select']:checked");
            if (!idxTemp) {
                alert('삭제대상이 선택되지 않았습니다.');
                return false;
            }
            let idx = idxTemp.getAttribute('data-value');

            Goods.prototype.setPurpose('searchGoodsDel');
            Goods.prototype.setMethodType('get');
            let data = {
                'goodsManageIdx': idx,
            }
            Goods.prototype.request(data);
        });

        // 엑셀 다운로드 버튼 :: data-target에 request할 조건 별칭 입력
        const downBtnExcel = document.querySelector('.excel-down-btn');
        if(downBtnExcel) {
            downBtnExcel.addEventListener('click', el => {
                switch(downBtnExcel.getAttribute('data-list')){
                    case "front":
                        // 사업부에서 관리자 페이지에 노출된 데이터만 다운로드되면 된다 전달받아 프론트엔드에서 처리 가능할것으로 판단하여 별도 처리
                        // <button class="btn btn-primary excel-down-btn" data-list="front" data-id="adminTable" data-hidden="18, 19" data-name="얼리큐_사용처정보" type="button">Excel</button>
                        // 와 같은 형태로 지정 data-id=테이블 데이터 노출되는 tbody, hidden의 경우 엑셀다운로드가 필요없는 컬럼 지정, data-name 의 경우 파일명
                        // data-id,  data-name 필수 , data-hidden 선택
                        let originTable = document.getElementById(downBtnExcel.getAttribute('data-id')).parentNode;
                        let targetTable = originTable.cloneNode(true);
                        if (downBtnExcel.getAttribute('data-hidden') !== null) {
                            let removeArray = downBtnExcel.getAttribute('data-hidden').split(",");
                            if (removeArray.length > 0) {
                                let removeTargetArray = [];
                                removeArray.forEach((e) => {
                                    removeTargetArray.push(`th:nth-child(${e}), td:nth-child(${e})`);
                                });
                                let removeTarget = targetTable.querySelectorAll(removeTargetArray.join(","));
                                removeTarget.forEach((e) => {
                                    e.remove();
                                });
                            }
                        }
                        let wb = XLSX.utils.table_to_book(targetTable, {sheet: "sheet1", raw: true});
                        XLSX.writeFile(wb, (`${downBtnExcel.getAttribute('data-name')}.xlsx`));
                        break;
                    default:
                        this.setPurpose('excelFileDown');
                        let form = document.createElement('form');
                        form.target = '_blank';
                        form.method = 'POST';
                        form.action = location;
                        let input = document.createElement('input');
                        input.setAttribute("type", "hidden");
                        input.setAttribute("name", 'target');
                        input.setAttribute("value", downBtnExcel.getAttribute('data-target'));
                        form.appendChild(input);
                        input = document.createElement('input');
                        input.setAttribute("type", "hidden");
                        input.setAttribute("name", 'purpose');
                        input.setAttribute("value", this.getPurpose());
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                        break;
                }
            });
        }

        // sample 양식 다운로드 버튼
        const sampleDownBtn = document.getElementById('sampleDownBtn');
        if(sampleDownBtn) {
            sampleDownBtn.addEventListener('click', e => {
                window.open('https://ds.genocorebs.com/back-office/resources/files/'+sampleDownBtn.getAttribute('data-filename'));
            });
        }

        // 모달 초기화 버튼
        const modalInit = document.querySelector('.modal-init-btn');
        if (modalInit) {
            modalInit.addEventListener('click', e => {
                const modalId = modalInit.getAttribute('data-bs-target').replace('#', '');
                const target = document.getElementById(modalId);
                target.querySelectorAll('input, select').forEach(function (el, i) {
                    if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    } else if(el.type !== 'radio') {
                        el.value = null;
                    }
                });
                this.deleteCatalogList();
            });
        }
        // 등록 버튼
        const registBtn = document.querySelectorAll('.regist-btn');
        registBtn.forEach(el => {
            el.addEventListener('click', e => {
                let data = {};
                const selector = e.target.getAttribute('data-target');
                const modal = document.querySelector('.' + selector);
                try {
                    modal.querySelectorAll('input, select').forEach(function (el) {
                        const cl = el.classList;
                        if (cl.contains('required-value')) {
                            if (el.type === 'checkbox') {
                                //동일 name 체크박스가 선택되어있는지 체크
                                if (!modal.querySelectorAll(`input[name='${el.name}']:checked`).length) throw new Error("필수값 미입력");
                            } else {
                                if (!el.value) throw new Error("필수값 미입력");
                            }
                        }
                        if (el.value) {
                            if (el.type === 'checkbox' || el.type === 'radio') {
                                if (el.checked) data[el.name] = el.value;
                            } else {
                                data[el.name] = el.value;
                            }
                        }
                    });
                } catch (e) {
                    alert("필수값을 입력해주세요.");
                    return;
                }

                //상품등록 / 수정과 같은 데이터 특이케이스건 위한 예외처리 및 함수
                if (confirm('정말 등록하시겠습니까?')) {
                    Goods.prototype.setPurpose(selector);
                    Goods.prototype.setMethodType('POST');
                    Goods.prototype.request(data);
                }
            });
        });
    }
    callback(response)
    {
        if(response) {
            if (response.code === '31200') {
                if (Goods.prototype.getMethodType() === 'POST') {
                    alert('완료되었습니다.');
                    location.reload();
                    return;
                }
                const data = response.data;
                switch (Goods.prototype.getMethodType()) {
                    case 'goods' :
                        const table = document.getElementById('adminTable');
                        while (table.firstChild) {
                            table.removeChild(table.firstChild);
                        }
                        //this.rendering(data.data, this.pagination.start);
                        //this.setEventListener(mainScript._purpose);
                        //this.pagination(data.pagination);
                        break;
                    default :
                        Goods.prototype.setModal(response);
                        break;
                }
                for (let key in data) {
                    if (key.search('::') !== -1) {
                        Goods.prototype.setForm(key, data[key]);
                    }
                }

            } else {
                alert(response.message);
                return false;
            }
        }
    }
    setModal(response)
    {
        if (response) {
            if (response.code === '31200') {
                let data = response.data;
                let selector;
                if (Goods.prototype.getPurpose() === 'searchGoodsEdit') { //굿즈 조회(수정)
                    // modal 대상
                    selector = '#goodsManage';
                    document.querySelector("#goodsManage input[name='goodsManageIdx']").value = data.goodsManageIdx;
                    document.querySelector("#goodsManage input[name='goodsManageType']").value = 'edit';
                    document.querySelector("#goodsManage #serviceCompany").value = data.serviceCompanyManageIdx;
                    document.querySelector("#goodsManage #goodsName").value = data.goodsName;
                    document.querySelector("#goodsManage input[name='salesPrice']").value = data.salesPrice;
                    document.querySelector("#goodsManage #goodsModalTitle").innerHTML = "기존 결제 경로 수정";
                    document.querySelector("#goodsManage .regist-btn").innerHTML = "수정";
                } else if (Goods.prototype.getPurpose() === 'searchGoodsDel') { //굿즈 조회(삭제)
                    // modal 대상
                    selector = '#goodsDelete';
                    if (document.querySelector("#goodsInfo ul")) {
                        document.querySelector("#goodsInfo ul").remove();
                    }
                    const goodsInfo = document.getElementById("goodsInfo");
                    const ul = document.createElement("ul");
                    const li1 = document.createElement("li");
                    li1.innerText = `등록일자 :  ${data.regDatetime}`;
                    ul.appendChild(li1);
                    const li2 = document.createElement("li");
                    li2.innerText = `굿즈코드 :  ${data.goodsManageIdx}`;
                    ul.appendChild(li2);
                    const li3 = document.createElement("li");
                    li3.innerText = `사용처 :  ${data.serviceCompanyName}`;
                    ul.appendChild(li3);
                    const li4 = document.createElement("li");
                    li4.innerText = `굿즈명 :  ${data.goodsName}`;
                    ul.appendChild(li4);
                    const li5 = document.createElement("li");
                    li5.innerText = `계약단가 :  ${data.salesPrice}`;
                    ul.appendChild(li5);

                    goodsInfo.appendChild(ul);

                    document.querySelector("#goodsDelete input[name='goodsManageIdx']").value = data.goodsManageIdx;
                }
                console.log(selector);
                const modalEl = document.querySelector(selector);
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            } else {
                alert('error,,');
            }
        } else {
            alert('main error,,');
        }
    }
    setForm (key, data) {
        const type = key.split('::')[0];
        const id = key.split('::')[1];
        // 셀렉트박스 세팅
        if (type === 'select') {
            const target = document.getElementById(id);
            if (target) {
                if (target.length === 1) {
                    for (let key in data) {
                        const option = document.createElement('option');
                        option.text = data[key]['text'];
                        option.value = data[key]['value'];
                        target.appendChild(option);
                    }
                }
            }
        }
    }
    sendRequest(type, url, data, success, error = "", complete = "")
    {
        let result = "";
        return new Promise((resolve, reject) => {
            const httpRequest = new XMLHttpRequest();
            httpRequest.open(type, url, true);
            httpRequest.responseType = 'json';
            httpRequest.send(data);

            // ajax response
            httpRequest.onreadystatechange = (e) => {
                if (httpRequest.readyState === 4) {
                    result = httpRequest.response;
                    (parseInt(httpRequest.status) === 200) ? resolve() : reject();
                }
            }
        }).then(() => {
            if (typeof success == "function") {
                if (typeof complete !== "function") {
                    return success(result);
                }
                success(result);
            }
        }).catch(() => {
            if (typeof error == "function") {
                if (typeof complete !== "function") {
                    return error(result);
                }
                error(result);
            }
        }).finally(() => {
            if (typeof complete == "function") {
                return complete(result);
            }
        });
    }
    request(data)
    {
        let url = document.location.href;
        let methodType = this.getMethodType();
        if (methodType === 'get') {
            data = [...this.dataset(data).entries()];
            data = data
                .map(x => `${encodeURIComponent(x[0])}=${encodeURIComponent(x[1])}`)
                .join('&');
            const operator = url.indexOf('?') > 0 ? '&' : '?';
            url += operator + data;
        } else {
            let formData = new FormData;
            let purpose = this.getPurpose();
            formData.append('purpose', purpose);
            if (data) {
                for (let key in data) {
                    formData.append(key, data[key]);
                }
            }
            data = formData;
        }
        this.sendRequest(methodType, url, data, '','', this.callback);
    }
}
Goods.prototype.setEventListener();
