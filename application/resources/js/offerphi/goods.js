class Admin {
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
    setEventListener()
    {
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
                adminScript.deleteCatalogList();
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
                if (typeof this.register !== 'undefined') {
                    this.setPurpose(selector);
                    this.register(data);
                } else {
                    if (confirm('정말 등록하시겠습니까?')) {
                        this.setPurpose(selector);
                        this.setMethodType('POST');
                        this.request(data);
                    }
                }
            });
        });
    }
    callback(response)
    {
        if (response) {
            if (response.code === '20200') {
                // 메뉴 세팅
                adminScript.makeMenu(response.data);
            }
        }
        this.setEventListener();
    }
    request()
    {
        let data = null;
        let url = document.location.href;
        if (this._methodType === 'get') {
            data = [...this.dataset().entries()];
            data = data
                .map(x => `${encodeURIComponent(x[0])}=${encodeURIComponent(x[1])}`)
                .join('&');

            const operator = url.indexOf('?') > 0 ? '&' : '?';
            url += operator + data;
        } else {
            data = this.dataset();
        }
        this.sendRequest(this.getMethodType(), url, data, '', this.callback);
    }
    register()
    {

    }
}
Admin.prototype.setEventListener();
