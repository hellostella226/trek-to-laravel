<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use HasFactory;
    protected $conn = null;
    // Mode::create()시 입력하는 필드
    protected $fillable =[];
    // 모델 속성 중 일부에 대한 기본값을 정의하는 경우, 데이터베이스에서 read한것과 같이 "저장 가능한" 형식이어야 함
    protected $attributes = [];
    // 특정 연결을 지정하려면 정의
    protected $connection = 'phi';
    // model의 타임스탬프 형식을 맞춤설정 해야 하는경우 설정
    protected $dateFormat = 'U';
    // timestamp를 저장하는데 사용되는 열의 이름을 사용자 정의하는 경우
    const CREATED_AT = 'RegDatetime';
    const UPDATED_AT = 'ModDatetime';

    // 관례적으로 $table을 명시적으로 기재하지 않는 한, 클래스의 복수형 이름인 스네이크케이스가 테이블 이름으로 사용
    protected $table = 'ProductGroup';
    protected $primaryKey = 'ProductGroupIdx';
    // 자동으로 증가하는 정수 값인 경우 true,  비증분 or 숫자가 아닌 경우 false
    public $incrementing = true;
    // created_at, updated_at이 있을것이라고 가정하고 자동으로 열 값을 설정함, 자동관리를 원하지 않는 경우 속성 false
    public $timestamps = false;

    use HasFactory;


    public string $code = "200";
    public array $data = [];
    public string $msg = "";
    public string $desc = "";
    // img 개발서버 경로
    private string $imgUrl = "https://img.genocorebs.com";
    // 요약결과 페이지 URL
    private string $personalLinkUrl = "ds.genocorebs.com/phi/?eCode=personal_link";
    // 질병예측결과지 확인 페이지 URL
    private string $phiReportUrl = "ds.genocorebs.com/phi/?eCode=phi_report";
    //U2medtek INFO
    private string $apiUrlU2 = "https://vital-gc.u2medtek.com";
    //BizM INFO
    private string $apiBizMUrl = "https://alimtalk-api.bizmsg.kr";
    private string $apiBizMId = "genocorebs";
    private string $apiBizMKey = "";
    private string $apiBizMPhiKey = "49e3f188af5471bc5077a725a84fda90196c2c47";
    private string $apiBizMEarlyQKey = "f4c4e6d56092c4501f045b5ed4ba2aa8aeb3182d";
    private string $apiBizMBioAgeKey = "55586d8acc54dd5a378735f23f5b07c835f85855";
    private string $apiBizMCouponKey = "45bcef8a291b86a34a11ef2165aed4fd9466e879";
    //infis INFO
    private string $apiInfisUrl = "https://infis.mrkim.co.kr/service/api/request-refine/search/refine";
    private string $apiInfisKey = "eyJhbGciOiJSUzUxMiJ9.eyJpZCI6IjU1OGNkNmNkLTg1NDgtY2JkMi0yM2UxLTIyMjg0ODIxMmU2MyIsIm5hbWUiOiLqtIDrpqzsnpAiLCJ1c2VybmFtZSI6IklORklTIiwidGVhbUlkIjoiNTU4Y2Q2Y2QtODU0OC1jYmQyLTIzZTEtMjIyODQ4MjEyZTYzIiwiZW1haWwiOiIiLCJ0ZW1wb3JhcnlBZG1pbiI6IlkiLCJhdXRob3JpdGllcyI6IkFETUlOXHRVU0VSIiwiaWF0IjoxNjYzNTc4MjY4LCJleHAiOjE5NzM0Njc1NzV9.BAylqbaVtNf7nxQm1qyhMSJLD-_M5povq-tcyXslY3St6k9yhNChmDJXPvGGRZt6EPnnXjxSJiXdN-CzWn6PfN46l0oDNO-nHUuWwEOikqV8_nsU2kAhUaB36ofXk5UCT8TWL3ZYJ4yqAalGEW8FLpv3n2rto9QVvkthFbot5g-IbyU0SyTTbz7IrJldb7eZS9TQ8q_fN7tWtjPP1Ng4kad21oAjyOJtbJ0-AsTCdffXz39QhNZBYn2oohUWhtf-JwD1XzXJnTzC7CHn36xLp0tRwW1pP_XR3udpDlOXgMXvXOfyE-ZqFbt61c8CoWWPfv3stMP3UqcCLx13aoGAKg9LLs4C9OYtGHPAdD8dpSp4Z6YopxmkaYplDd23QVt-UpNeS-hQ7hfKQlyLqPqUlMKAzuTYCqwVkciQm2MBoSPyVDd9lFoaW8c4q9bYQzNefl1ywTaydMOyv1rkcf3ot0Emlzr8DE-jN13dzuX_P4LCetmuNmgFfdhIF4IQSiFx_j5OG33_duENlIue7niIK-FxmUb6lAIEX8ecschUOOMGm9KqA2AL1x8-7C-qkJ0XgjkHhhU6_EGB-MJR-N57rIBTc0pDiL4Oi5fUla9MeIRv7Y9NO1csv0XsIX-o5G6a9Q_ay0MotSVhNFZhG0EICj0646IjafANOKvdb7K_9lE";
    private string $apiLabgeUrl = "https://interface.labgenomics.com/api/genocore/patientInfo/change";
    private string $apiLabgeKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYmYiOjE2NzA4MzMwMjMsImV4cCI6MjE0NDIxODYyMywiaWF0IjoxNjcwODMzMDIzLCJpc3MiOiJsYWJnZW5vbWljcyIsImF1ZCI6Imdlbm9jb3JlIn0.EDfZcSVwVAf3kCK7MgqKwRO5Rzkug-ZHdzzYWqEUhLU";
    private string $kcpRefundUrl = "https://spl.kcp.co.kr/gw/mod/v1/cancel";
    private string $kcpInqueryUrl = "https://spl.kcp.co.kr/std/inquery";
    private string $kcpCertInfo = "";
    private string $kcpSignPw = "dbwjswkwndtla2022##";
    private array $bioMarkerCode = [
        '11' => [
            'name' => 'diabetes',
            'title' => '당뇨병'
        ],
        '12' => [
            'name' => 'liver_disease',
            'title' => '간장질환'
        ],
        '13' => [
            'name' => 'stomach_cancer',
            'title' => '위암'
        ],
        '14' => [
            'name' => 'stroke',
            'title' => '뇌졸중'
        ],
        '15' => [
            'name' => 'kidney_disease',
            'title' => '신장질환'
        ],
        '16' => [
            'name' => 'heart_disease',
            'title' => '심장질환'
        ],
        '17' => [
            'name' => 'alzheimers',
            'title' => '알츠하이머'
        ],
        '18' => [
            'name' => 'liver_cancer',
            'title' => '간암'
        ],
        '21' => [
            'name' => 'lung_cancer',
            'title' => '폐암'
        ],
        '22' => [
            'name' => 'colorectal_cancer',
            'title' => '대장암'
        ],
        '23' => [
            'name' => 'thyroid_cancer',
            'title' => '갑상선암'
        ],
        '24' => [
            'name' => 'pancreatic_cancer',
            'title' => '췌장암'
        ],
        '25' => [
            'name' => 'prostate_cancer',
            'title' => '전립선암'
        ],
        '26' => [
            'name' => 'breast_cancer',
            'title' => '유방암'
        ],
        '27' => [
            'name' => 'myocardial_infarction',
            'title' => '심근경색'
        ],
        '28' => [
            'name' => 'high_blood_pressure',
            'title' => '고혈압'
        ],
        '29' => [
            'name' => 'lung_cancer_smoking',
            'title' => '폐암_담배'
        ]
    ];
    private array $bioMarkerRank = [
        '심장질환' => 1,
        '간장질환' => 2,
        '췌장암' => 3,
        '당뇨병' => 3,
        '신장질환' => 4,
    ];
    private array $supplements = [
        '심장질환' => [
            '고위험' => '오메가3',
            '위험' => '오메가3',
            '경고' => '오메가3',
            '주의' => '코엔자임Q10',
            '양호' => '코엔자임Q10',
        ],
        '간장질환' => [
            '고위험' => '밀크씨슬',
            '위험' => '밀크씨슬',
            '경고' => '밀크씨슬',
            '주의' => '비타민 B',
            '양호' => '비타민 B',
        ],
        '췌장암' => [
            '고위험' => '바나바잎추출물',
            '위험' => '바나바잎추출물',
            '경고' => '바나바잎추출물',
            '주의' => '난소화성말토덱스트린',
            '양호' => '난소화성말토덱스트린',
        ],
        '당뇨병' => [
            '고위험' => '바나바잎추출물',
            '위험' => '바나바잎추출물',
            '경고' => '바나바잎추출물',
            '주의' => '난소화성말토덱스트린',
            '양호' => '난소화성말토덱스트린',
        ],
        '신장질환' => [
            1 => [
                '고위험' => '쏘팔메토',
                '위험' => '쏘팔메토',
                '경고' => '쏘팔메토',
                '주의' => '셀레늄',
                '양호' => '셀레늄',
            ],
            2 => [
                '고위험' => '크랜베리',
                '위험' => '크랜베리',
                '경고' => '크랜베리',
                '주의' => '셀레늄',
                '양호' => '셀레늄',
            ]
        ],
    ];
    public array $pattern = [
        'all' => '/^[가-힣a-zA-Z0-9\_\.\,\-\s\(\)]+$/',
        'code' => '/^[a-zA-Z0-9\_]+$/',
        'kor' => '/^[가-힣\s]+$/',
        'eng' => '/^[a-zA-Z\s]+$/',
        'num' => '/^[0-9]+$/',
        'email' => '/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i',
        'date' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
        'survey' => '/^[1-6\,]+$/'
    ];

    public array $defineStatusCode = [
        '1' => [
            '5' => [
                'A' => [
                    '21000' => '유전자검사 신청 진입'
                ],
                'B' => [
                    '21000' => '거주지 입력 완료'
                ],
                'C' => [
                    '21000' => '동의항목 체크 및 서명등록'
                ],
                'E' => [
                    '21900' => '약관동의 저장 실패',
                    '20100' => '약관동의 저장 성공',
                    '20190' => '유전자검사 신청서 생성 오류',
                    '20010' => '유전자검사 신청서 생성 성공',
                    '20019' => '유전자검사 신청서 전송 오류',
                    '20000' => '유전자검사 신청서 전송 성공',
                ],
            ],
            '6' => [
                'A' => [
                    '21000' => '유전자검사 신청 진입'
                ],
                'B' => [
                    '21000' => '거주지 입력 완료'
                ],
                'C' => [
                    '21000' => '동의항목 체크 및 서명등록'
                ],
                'E' => [
                    '21900' => '약관동의 저장 실패',
                    '20100' => '약관동의 저장 성공',
                    '20190' => '유전자검사 신청서 생성 오류',
                    '20010' => '유전자검사 신청서 생성 성공',
                    '20019' => '유전자검사 신청서 전송 오류',
                    '20000' => '유전자검사 신청서 전송 성공',
                ],
            ],
        ],
        '7' => [
            '8' => [
                'A' => [
                    '21000' => '설문응답 신청 진입'
                ],
                'E' => [
                    '20009' => '설문응답 등록 실패',
                    '20000' => '설문응답 등록 완료 [P]',
                ],
            ],
        ],
        '12' => [
            '2' => [
                'A' => [
                    '21000' => '회원 등록 완료',
                ],
                'B' => [
                    '21000' => '약관동의 시도',
                ],
                'C' => [
                    '20100' => '간편인증 요청 성공',
                ],
                'E' => [
                    '20000' => '결과지 생성 성공',
                ],
            ],
            // ProductIdx = 3 : 이전 UserLatestStatus > Process 및 StatusCode 값 정의
//            '3' => [
//                'A' => [
//                    '21000' => '회원 등록 완료 및 간편인증 요청 성공',
//                ],
//                'B' => [
//                    '20010' => '스크래핑 성공',
//                    '20100' => '스크래핑 실패'
//                ],
//                'C' => [
//                    '20019' => '결과지 생성 실패',
//                ],
//                'E' => [
//                    '20000' => '결과지 생성 성공',
//                ],
//            ],
            '3' => [
                'A' => [
                    '21000' => '회원 등록 완료 [A,B]',
                    '22000' => '상태 오류발생'
                ],
                'B' => [
                    '22000' => '약관동의 저장 [C]'
                ],
                'C' => [
                    '20100' => '간편인증 요청 성공 [D]',
                    '22900' => '간편인증 요청 실패(본인인증 실패) [E]',
                    '22800' => '간편인증 요청 실패(인증 에러 안내) [F]',
                    '22700' => '간편인증 요청 실패(인증서 오류 안내) [G]',
                    '22600' => '인증 없이 버튼 클릭한 경우 * 임의 신규생성',
                ],
                'D' => [
                    '20200' => '스크래핑 성공',
                    '20190' => '스크래핑 실패 [H]',
                    '20180' => '스크래핑 성공, 공단이력 없음 [I]',
                ],
                'E' => [
                    '20000' => '결과지 생성 완료 [K]',
                    '20019' => '결과지 생성 실패 [J]',
                ],
            ],
            '14' => [
                'A' => [
                    '21000' => '회원 등록 완료 [A,B]',
                    '22000' => '상태 오류발생'
                ],
                'B' => [
                    '22000' => '약관동의 저장 [C]'
                ],
                'C' => [
                    '20100' => '간편인증 요청 성공 [D]',
                    '22900' => '간편인증 요청 실패(본인인증 실패) [E]',
                    '22800' => '간편인증 요청 실패(인증 에러 안내) [F]',
                    '22700' => '간편인증 요청 실패(인증서 오류 안내) [G]',
                    '22600' => '인증 없이 버튼 클릭한 경우 * 임의 신규생성',
                ],
                'D' => [
                    '20200' => '스크래핑 성공',
                    '20190' => '스크래핑 실패 [H]',
                    '20180' => '스크래핑 성공, 공단이력 없음 [I]',
                ],
                'E' => [
                    '20010' => '결과지 생성 완료 [K]',
                    '20019' => '결과지 생성 실패 [J]',
                    '20009' => '맞춤영양 생성 실패',
                    '20000' => '맞춤영양 생성 완료 [L]',
                ],
            ],
        ],
        '13' => [
            // ProductIdx = 4 : 이전 UserLatestStatus > Process 및 StatusCode 값 정의
//            '4' => [
//                'A' => [
//                    '21000' => '보험상담 신청 진입',
//                    '20190' => '약관동의 저장 실패',
//                    '20010' => '약관동의 저장',
//                ],
//                'E' => [
//                    '20000' => '요일/시간 등록 완료',
//                    '20019' => '요일/시간 등록 실패',
//                ]
//            ],
            '4' => [
                'A' => [
                    '21000' => '보험상담 신청 진입'
                ],
                'B' => [
                    '20100' => '보험상담 동의 저장 [M]'
                ],
                'E' => [
                    '20000' => '요일/시간 등록 완료 [N,O]',
                    '20009' => '요일/시간 등록 실패',
                ]
            ],
        ],
    ];

    // 엑셀 다운로드
    function excelFileDown($param) : void
    {
        $this->desc = 'excelFileDown';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            switch($param['target']) {
                case 'consultantData':
                    $data = $this->consultantData($param);
                    $headers = [
                        '상담사계정코드', '등록일자', '최종수정일자', '등록방식', '사용처', '회사명', '상담사',
                        '전화번호', '결제수량', '결제잔량','무료지급량','무료잔량','질병예측서비스url','사용여부'
                    ];
                    $fileName = "상담사등록관리_";
                    break;
                default :
                    $headers = [];
                    $fileName = "notitle";
                    break;
            }

            $spreadsheet = new SpreadsheetFactory();
            $spreadsheet->downloadSheet($headers, $data, $fileName);

            exit;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    function __construct()
    {
        if (isDev) {
            // 유투메디텍 개발서버 테스트 api
            $this->apiUrlU2 = "https://dev-vital.u2medtek.com";
            // 비즈엠 개발서버 테스트 api
            $this->apiBizMUrl = "https://dev-alimtalk-api.bizmsg.kr:1443";
            $this->apiBizMKey = "cb1ce15c8d0dac79dd016f3c34a50539f2d1b6cc";
            $this->apiBizMId = "sweet_partner";
            // img 개발서버 경로
            $this->imgUrl = (location === 'develop') ? 'http://timg.genocorebs.com' : 'http://limg.genocorebs.com';
            // kcp 환불 개발 api
            $this->kcpRefundUrl = "https://stg-spl.kcp.co.kr/gw/mod/v1/cancel";
            // kcp 조회 개발 api
            $this->kcpInqueryUrl = "https://stg-spl.kcp.co.kr/std/inquery";
            $this->kcpSignPw = "changeit";
        }

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/pay/certificate/splCert.pem")) {
            $this->kcpCertInfo = preg_replace('/\r\n|\r|\n/', '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/pay/certificate/splCert.pem"));
        }
        if (!$this->conn) {
            $this->conn = DB::connection()->getPdo();
        }
    }


    // 유저 쿠폰 사용 내역 조회
    /*function userCouponList($param) : array
    {
        $this->desc = 'userCouponList';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['cm.CouponName', 'cm.CouponCode'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, cm.RegDatetime DESC ";
            } else {
                $orderSql .= ' cm.RegDatetime DESC ';
            }

            $sql = "SELECT  icm.CouponIdx, icm.ClientCustomerManageIdx AS IcmClientIdx, icm.IssuedDatetime
                            , cm.CouponManageIdx, cm.CouponType, cm.CouponCode, cm.CouponName
                            , cm.DiscountMethod, cm.ClientCustomerManageIdx, cm.UseStartDate, cm.UseEndDate
                            , cm.CouponStatus, cm.RegDatetime
                     FROM phi.IssuedCouponManage AS icm
                     JOIN phi.`CouponManage` AS cm
                       ON cm.CouponManageIdx = icm.CouponManageIdx
                    WHERE cm.IsUse = b'1'
                      AND cm.ProductGroupIdx = :productGroupIdx
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();

            $data = [];
            while($row = $stmt->fetch()) {
                $data[] = [
                    'couponManageIdx' => $row['CouponManageIdx'],
                    'couponType' => $row['CouponType'],
                    'couponName' => $row['CouponName'],
                    'clientCustomerManageIdx' => $row['ClientCustomerManageIdx'],
                    'useStartDate' => $row['UseStartDate'],
                    'useEndDate' => $row['UseEndDate'],
                    'couponStatus' => $row['CouponStatus'],
                    'regDatetime' => $row['RegDatetime'],
                    'couponIdx' => $row['CouponIdx'],
                    'icmClientIdx' => $row['IcmClientIdx'],
                    'issuedDatetime' => $row['IssuedDatetime'],
                ];
            }
            $this->data['data'] = $data;
            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }*/

    // 유저 쿠폰 사용 내역 조회
    function userCouponList($param) : array
    {
        $this->desc = 'userCouponList';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['cm.CouponName', 'cm.CouponCode'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, cm.RegDatetime DESC ";
            } else {
                $orderSql .= ' cm.RegDatetime DESC ';
            }

            $sql = "SELECT
                         ecm.ExpiredCouponIdx,ecm.CouponIdx,ecm.CouponManageIdx,ecm.CouponCode
                        ,ecm.ClientCustomerManageIdx,ecm.IssuedDatetime,ecm.ExpiredType,ecm.ExpiredDatetime
                        ,cm.CouponName, scm.ServiceCompanyName, ccm.ClientCustomerName
                    FROM
                    phi.`ExpiredCouponManage` AS ecm
                     JOIN phi.`CouponManage` AS cm
                       ON cm.CouponManageIdx = ecm.CouponManageIdx
                     JOIN phi.ClientCustomerManage AS ccm
                       ON ccm.ClientCustomerManageIdx = ecm.ClientCustomerManageIdx
                     JOIN phi.ServiceCompanyManage AS scm
                       ON scm.ServiceCompanyManageIdx = ccm.ServiceCompanyManageIdx
                    WHERE cm.IsUse = b'1'
                      AND cm.ProductGroupIdx = :productGroupIdx
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();

            $data = [];
            while($row = $stmt->fetch()) {
                $data[$row['ExpiredCouponIdx']] = [
                    'expiredCouponIdx' => $row['ExpiredCouponIdx'],
                    'couponIdx' => $row['CouponIdx'],
                    'couponManageIdx' => $row['CouponManageIdx'],
                    'couponCode' => $row['CouponCode'],
                    'couponName' => $row['CouponName'],
                    'clientCustomerManageIdx' => $row['ClientCustomerManageIdx'],
                    'clientCustomerName' => $row['ClientCustomerName'],
                    'serviceCompanyName' => $row['ServiceCompanyName'],
                    'issuedDatetime' => $row['IssuedDatetime'],
                    'expiredType' => $row['ExpiredType'],
                    'expiredDatetime' => $row['ExpiredDatetime'],
                ];
            }
            $this->data['data'] = $data;
            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }
    // 결제취소 후 BizM 발송 (ProcessStep : 43, 44, 45)
    function sendRefundSms($param) : array
    {
        $this->desc = "model::sendClientSms";
        try {
            if (
                !isset(
                    $param['payOrderCode'],
                    $param['buyerName'],
                    $param['buyerPhone'],
                    $param['refundType'],
                    $param['refundDate'],
                    $param['refundQuantity'],
                    $param['refundAmount'],
                    $param['clientCustomerManageIdx']
                )
            ) {
                throw new \Exception("필수 파라미터가 없습니다.", "404");
            }

            if ($param['refundType'] === 'STSC') {
                $processStep = [43];
            } else {
                $processStep = [44, 45];
            }

            $sql = "SELECT TemplateIdx, ProductGroupIdx, ProcessStep, SubDivisionType, TemplateCode, Message
                      FROM sms.BizMTemplateManage
                     WHERE ProcessStep IN (" . implode(",", $processStep) . ")
                       AND IsUse = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $bizMTemplateList = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];
            if (count($bizMTemplateList) === 0) {
                throw new \Exception("사용 가능한 BizM 템플릿이 없습니다.", "404");
            }

            $bizMParamList = [];
            foreach ($bizMTemplateList as $template) {
                $bizMParam = [
                    'templateId' => $template['TemplateCode'],
                    'messageType' => 'AI',
                    'phone' => (isDev) ? '01041033708' : $param['buyerPhone'],
                    'message' => '',
                    'title' => "",  //제목
                    'reserveDatetime' => '00000000000000',  //수신시간
                    'smsKind' => "L",
                    'smsSender' => "0316286176",
                    'processStep' => $template['ProcessStep'],
                    'messageSms' => '',
                    'smsLmsTit' => '',
                ];

                $message = $template['Message'];
                $message = str_replace('#{구매자}', $param['buyerName'], $message);

                switch ($template['ProcessStep']) {
                    case '43':
                        $message = str_replace('#{취소일}', $param['refundDate'], $message);
                        $message = str_replace('#{취소건수}', $param['refundQuantity'], $message);
                        $message = str_replace('#{취소금액}', $param['refundAmount'], $message);

                        $bizMParam['messageSms'] = $message;
                        break;
                    case '44':
                        $message = str_replace('#{부분취소일}', $param['refundDate'], $message);
                        $message = str_replace('#{부분취소건수}', $param['refundQuantity'], $message);
                        $message = str_replace('#{부분취소금액}', $param['refundAmount'], $message);

                        $bizMParam['messageSms'] = $message;
                        break;
                    case '45':
                        $sql = "SELECT
                                    OrderQuantity, OrderType
                                  FROM pay.PaymentManage
                                 WHERE PayOrderCode = :payOrderCode";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindValue(':payOrderCode', $param['payOrderCode']);
                        $stmt->execute();
                        $afterRefundQuantity = 0;
                        while ($row = $stmt->fetch()) {
                            if ($row['OrderType'] === '1') {
                                $afterRefundQuantity += (int)$row['OrderQuantity'];
                            } else {
                                $afterRefundQuantity -= (int)$row['OrderQuantity'];
                            }
                        }

                        $message = str_replace('#{주문건수-부분취소}', $afterRefundQuantity, $message);

                        $sql = "SELECT ClientCustomerCode
                                  FROM phi.ClientCustomerManage
                                 WHERE ClientCustomerManageIdx = :clientCustomerManageIdx";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindValue(':clientCustomerManageIdx', $param['clientCustomerManageIdx'], $this->conn::PARAM_INT);
                        $stmt->execute();
                        $clientCustomerCode = $stmt->fetch()['ClientCustomerCode'] ?? '';
                        if (!$clientCustomerCode) {
                            throw new \Exception("상담사 조회 실패", "404");
                        }
                        $offerPhiUrl = "https://ds.genocorebs.com/phi/?hCode={$clientCustomerCode}";
                        $result = (new NaverShortUrl())->getResult(['url' => $offerPhiUrl]);
                        if ($result['code'] !== 200) {
                            throw new \Exception("URL 생성에 실패하였습니다.", "400");
                        }
                        $response = json_decode($result['response'], true);
                        $shortUrl = $response['result']['url'];

                        $bizMParam['messageSms'] = $message;
                        $bizMParam['shortUrl'] = $shortUrl;
                        $bizMParam['buttonName'] = "검사권 사용하기";
                        break;
                }

                $bizMParam['message'] = $message;

                $bizMParamList[] = $bizMParam;
            }

            return $this->sender($bizMParamList);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 결제내역 취소
    function refundPayment($param) : array
    {
        $this->desc = "model::refundPayment";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset(
                $param['payOrderIdx'],
                $param['kcpTno'],
                $param['orderType'],
                $param['payType'],
                $param['refundType'],
                $param['orderQuantity'],
                $param['orderAmount'],
                $param['refundDesc'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                !in_array($param['orderType'], [2, 3])
                || !in_array($param['refundType'], ['STSC', 'STPC'])
                || !preg_match($this->pattern['num'], $param['orderQuantity'])
                || !preg_match($this->pattern['num'], $param['orderAmount'])
                || !preg_match($this->pattern['all'], $param['refundDesc'])
            ) {
                throw new \Exception('파라미터가 올바르지 않습니다.', "400");
            }

            $sql = "SELECT
                        PayOrderIdx, RelatedPayOrderIdx, PayOrderCode, PGCompanyName, SiteCode,
                        GoodsManageIdx, GoodsName, SalesPrice, CouponCode, CompanyName,
                        BuyerName, BuyerPhone, PayMethod, KcpTno, PayType, ClientCustomerManageIdx,
                        TicketManageIdx
                      FROM pay.PaymentManage
                     WHERE PayOrderIdx = :payOrderIdx
                       AND KcpTno = :kcpTno
                       AND PayType = :payType
                       AND OrderType = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':payOrderIdx', $param['payOrderIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':kcpTno', $param['kcpTno']);
            $stmt->bindValue(':payType', $param['payType']);
            $stmt->execute();
            $paymentInfo = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];
            if (!$paymentInfo) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            // 환불수량 vs 남은 티켓 수량 비교 체크
            // $issuedTicketManageIdxArr는 추후 아래 티켓 회수 로직에서 사용됨
            $sql = "SELECT IssuedTicketManageIdx
                      FROM phi.IssuedTicketManage
                     WHERE TicketManageIdx = {$paymentInfo['TicketManageIdx']}
                  ORDER BY IssuedDatetime DESC
                     LIMIT :refundQuantity";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':refundQuantity', $param['orderQuantity'], $this->conn::PARAM_INT);
            $stmt->execute();
            $issuedTicketManageIdxArr = $stmt->fetchAll($this->conn::FETCH_COLUMN) ?? [];
            if (count($issuedTicketManageIdxArr) < $param['orderQuantity']){
                throw new \Exception('취소 가능 수량을 초과하였습니다.', "400");
            }

            // PaymentManage Insert
            $table = "pay.PaymentManage";
            $item = [
                'payOrderCode' => $paymentInfo['PayOrderCode'],
                'pGCompanyName' => $paymentInfo['PGCompanyName'],
                'siteCode' => $paymentInfo['SiteCode'],
                'goodsManageIdx' => $paymentInfo['GoodsManageIdx'],
                'goodsName' => $paymentInfo['GoodsName'],
                'salesPrice' => $paymentInfo['SalesPrice'],
                'couponCode' => $paymentInfo['CouponCode'] ?? 'null',
                'companyName' => $paymentInfo['CompanyName'],
                'buyerName' => $paymentInfo['BuyerName'],
                'buyerPhone' => $paymentInfo['BuyerPhone'],
                'payMethod' => $paymentInfo['PayMethod'],
                'orderType' => $param['orderType'],
                'orderQuantity' => $param['orderQuantity'],
                'orderAmount' => $param['orderAmount'],
                'orderStatus' => 0,
                'kcpTno' => $paymentInfo['KcpTno'],
                'payType' => $paymentInfo['PayType'],
                'clientCustomerManageIdx' => $paymentInfo['ClientCustomerManageIdx'],
                'ticketManageIdx' => $paymentInfo['TicketManageIdx'],
            ];
            $payOrderIdx = $this->insertUpdate([], $table, $item);

            if ($param['orderType'] === '2') {
                $keyData = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/pay/certificate/splPrikeyPKCS8.pem');
                $priKey = openssl_pkey_get_private($keyData, $this->kcpSignPw);
                $header = [
                    "Content-Type: application/json",
                    "charset=utf-8"
                ];

                // KCP 조회 API
                $targetData = "{$paymentInfo['SiteCode']}^{$paymentInfo['KcpTno']}^{$paymentInfo['PayType']}";
                openssl_sign($targetData, $signature, $priKey, 'sha256WithRSAEncryption');
                $kcpSignData = base64_encode($signature);
                $url = $this->kcpInqueryUrl;
                $data = [
                    "site_cd" => $paymentInfo['SiteCode'],
                    "kcp_cert_info" => $this->kcpCertInfo,
                    "kcp_sign_data" => $kcpSignData,
                    "tno" => $paymentInfo['KcpTno'],
                    "pay_type" => $paymentInfo['PayType'],
                ];
                $result = $this->curl('POST', $url, $header, json_encode($data));
                $resp = json_decode($result['response'], true);
                if ($resp['res_cd'] != '0000') {
                    throw new \Exception("결제 조회 실패: {$resp['res_msg']}", "500");
                }
                $remainingAmount = $resp['rem_mny'];

                // KCP 취소 API
                $cancelTargetData = "{$paymentInfo['SiteCode']}^{$paymentInfo['KcpTno']}^{$param['refundType']}";
                openssl_sign($cancelTargetData, $signature, $priKey, 'sha256WithRSAEncryption');
                $kcpSignData = base64_encode($signature);

                $url = $this->kcpRefundUrl;
                $header = [
                    "Content-Type: application/json",
                    "charset=utf-8"
                ];
                $data = [
                    "site_cd" => $paymentInfo['SiteCode'],
                    "kcp_cert_info" => $this->kcpCertInfo,
                    "kcp_sign_data" => $kcpSignData,
                    "tno" => $paymentInfo['KcpTno'],
                    "mod_type" => $param['refundType'],
                    "mod_mny" => (int)$param['orderAmount'], // 부분취소금액
                    "rem_mny" => (int)$remainingAmount, // 남은 원거래 금액
                    "mod_desc" => $param['refundDesc']
                ];
                $result = $this->curl('POST', $url, $header, json_encode($data));
                $resp = json_decode($result['response'], true);
                if ($resp['res_cd'] != '0000') {
                    throw new \Exception("결제 취소 실패: {$resp['res_msg']}", "500");
                }

                // KCP 취소 API 성공 이후에 DB 오류 발생 시, 대응할 수 있게
                // PaymentManage > OrderStatus = 9 `DB 오류` Update
                $table = "pay.PaymentManage";
                $idx = [
                    'payOrderIdx' => $payOrderIdx
                ];
                $item = [
                    'orderStatus' => 9,
                ];
                $this->insertUpdate($idx, $table, $item);

                // KCP 취소 API 통신 이후 PaymentManage Update
                $idx = [
                    'payOrderIdx' => $payOrderIdx
                ];
                $table = "pay.PaymentManage";
                $item = [
                    'approvedOrderAmount' => $resp['mod_mny'] ?? $param['orderAmount'],
                    'approvedDatetime' => date('Y-m-d H:i:s', strtotime($resp['canc_time']))
                ];
                $this->insertUpdate($idx, $table, $item);

                // RefundManage Insert
                $table = "pay.RefundManage";
                $item = [
                    'payOrderIdx' => $payOrderIdx,
                    'kcpTno' => $paymentInfo['KcpTno'],
                    'refundType' => $param['refundType'],
                    'refundDesc' => $param['refundDesc'],
                    'refundQuantity' => $param['orderQuantity'],
                    'refundAmount' => $param['orderAmount'],
                    'refundDate' => date('Y-m-d', strtotime($resp['canc_time'])),
                    'partialRefundCode' => $resp['mod_pacn_seq_no'] ?? '',
                    'approvedRefundAmount' => $resp['mod_mny'] ?? $param['orderAmount'],
                    'remainingAmount' => $resp['rem_mny'] ?? '',
                ];

                $this->insertUpdate([], $table, $item);
            }

            // 만료쿠폰 -> 유효쿠폰으로 (전체취소일 경우에 한하여; RefundType = STSC)
            if ($paymentInfo['CouponCode'] && $param['refundType'] === 'STSC') {
                $sql = "SELECT ecm.*, cm.CouponType
                          FROM phi.ExpiredCouponManage ecm
                          JOIN phi.CouponManage cm
                            ON cm.CouponManageIdx = ecm.CouponManageIdx
                         WHERE ecm.CouponCode = '{$paymentInfo['CouponCode']}'
                           AND ecm.ClientCustomerManageIdx = {$paymentInfo['ClientCustomerManageIdx']}
                      ORDER BY ecm.ExpiredDatetime DESC
                         LIMIT 1";
                $stmt = $this->conn->query($sql);
                $couponInfo = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];
                // 일회용 쿠폰일 경우 IssuedCouponManage Insert
                // 다회용 쿠폰일 경우 삭제만; 로직상 다회용 쿠폰은 IssuedCouponManage에 유지되었을테니..
                if ($couponInfo) {
                    if ($couponInfo['CouponType'] === '1'){
                        $table = "phi.IssuedCouponManage";
                        $item = [
                            'couponIdx' => $couponInfo['CouponIdx'],
                            'couponManageIdx' => $couponInfo['CouponManageIdx'],
                            'couponCode' => $couponInfo['CouponCode'],
                            'clientCustomerManageIdx' => $couponInfo['ClientCustomerManageIdx'],
                            'issuedDatetime' => $couponInfo['IssuedDatetime'],
                        ];
                        $this->insertUpdate([], $table, $item);
                    }
                    $sql = "DELETE FROM phi.ExpiredCouponManage
                            WHERE ExpiredCouponIdx = {$couponInfo['ExpiredCouponIdx']}";
                    $this->conn->query($sql);
                }
            }

            // 유효쿠폰 삭제
            $issuedTicketManageIdxList = implode(',', $issuedTicketManageIdxArr);
            $sql = "DELETE FROM phi.IssuedTicketManage
                    WHERE IssuedTicketManageIdx IN ({$issuedTicketManageIdxList})";
            $this->conn->query($sql);

            // PaymentManage 정상처리 Update
            $table = "pay.PaymentManage";
            $idx = [
                'payOrderIdx' => $payOrderIdx
            ];
            $item = [
                'orderStatus' => 1,
            ];
            $this->insertUpdate($idx, $table, $item);

            $this->data = [
                'payOrderCode' => $paymentInfo['PayOrderCode'],
                'buyerName' => $paymentInfo['BuyerName'],
                'buyerPhone' => $paymentInfo['BuyerPhone'],
                'refundType' => $param['refundType'],
                'refundDate' => $param['orderType'] === '2' ? date('Y-m-d', strtotime($resp['canc_time'])) : date('Y-m-d'),
                'refundQuantity' => $param['orderQuantity'],
                'refundAmount' => $param['orderAmount'],
                'clientCustomerManageIdx' => $paymentInfo['ClientCustomerManageIdx']
            ];

            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 굿즈관리 조회(수정 Modal)
    function searchPayment($param) : array
    {
        $this->desc = "model::searchPayment";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['payOrderIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            $sql = "SELECT
                        pm.PayOrderIdx, pm.CouponCode, cm.DiscountMethod, cm.DiscountAmount, cm.DiscountRate,
                        pm.PayOrderCode, pm.PayMethod, pm.GoodsName, pm.OrderAmount, pm.TotalDiscountAmount, pm.OrderQuantity,
                        scm.ServiceCompanyName, pm.CompanyName, pm.BuyerName,
                        pm.ApprovedDatetime, pm.SalesPrice, pm.KcpTno, pm.PayType, pm.ApprovedOrderAmount, pm.OrderType, pm.TicketManageIdx
                      FROM pay.PaymentManage pm
                      JOIN phi.GoodsManage gm
                        ON gm.GoodsManageIdx = pm.GoodsManageIdx
                      JOIN phi.ServiceCompanyManage scm
                        ON scm.ServiceCompanyManageIdx = gm.ServiceCompanyManageIdx
                 LEFT JOIN phi.CouponManage cm
                        ON cm.CouponCode = pm.CouponCode
                 LEFT JOIN pay.RefundManage rm
                        ON rm.PayOrderIdx = pm.PayOrderIdx
                     WHERE pm.PayOrderIdx = :payOrderIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':payOrderIdx', $param['payOrderIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch() ?? [];
            if (!$row) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }
            if ($row['OrderType'] != '1'){
                throw new \Exception("취소내역을 선택하셨습니다. \n결제내역을 선택하여 진행하시길 바랍니다.", "400");
            }

            $sql = "SELECT IssuedTicketManageIdx
                      FROM phi.IssuedTicketManage
                     WHERE TicketManageIdx = {$row['TicketManageIdx']}";
            $stmt = $this->conn->query($sql);
            $issuedTicketCnt = $stmt->rowCount();

            $this->data = [
                'payOrderIdx' => $row['PayOrderIdx'],
                'payOrderCode' => $row['PayOrderCode'],
                'payMethod' => $row['PayMethod'],
                'goodsName' => $row['GoodsName'],
                'couponCode' => $row['CouponCode'],
                'discountMethod' => $row['DiscountMethod'],
                'discountAmount' => $row['DiscountAmount'],
                'discountRate' => $row['DiscountRate'],
                'orderQuantity' => $row['OrderQuantity'],
                'remainOrderQuantity' => $issuedTicketCnt,
                'orderAmount' => $row['OrderAmount'],
                'totalDiscountAmount' => $row['TotalDiscountAmount'],
                'serviceCompanyName' => $row['ServiceCompanyName'],
                'companyName' => $row['CompanyName'],
                'buyerName' => $row['BuyerName'],
                'approvedOrderAmount' => $row['ApprovedOrderAmount'],
                'approvedDatetime' => $row['ApprovedDatetime'],
                'salesPrice' => $row['SalesPrice'],
                'kcpTno' => $row['KcpTno'],
                'payType' => $row['PayType'],
            ];

            return $this->response();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 결제내역 조회
    function paymentList($param) : array
    {
        $this->desc = "model::paymentList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['pm.GoodsName', 'scm.ServiceCompanyName', 'pm.CompanyName', 'pm.BuyerName', 'pm.BuyerPhone'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    if ($param['keyword'] === 'pm.PayOrderIdx') {
                        $addSql .= " AND ({$param['keyword']} = '{$param['value']}' OR pm.RelatedPayOrderIdx = '{$param['value']}')";
                    } else {
                        $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                    }
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, pm.RegDatetime DESC ";
            } else {
                $orderSql .= ' pm.RegDatetime DESC ';
            }

            // 대상 전체 카운트
            $sql = "SELECT
                        pm.PayOrderIdx, pm.RelatedPayOrderIdx, pm.RegDatetime, pm.PayOrderCode, pm.PayMethod,
                        pm.GoodsManageIdx, pm.GoodsName, pm.OrderAmount, ccm.ServiceCompanyManageIdx,
                        scm.ServiceCompanyName, pm.CompanyName, pm.BuyerName, pm.BuyerPhone, pm.OrderStatus,
                        pm.ApprovedDatetime, rm.RefundType, pm.OrderType
                    FROM pay.PaymentManage pm
                    JOIN phi.GoodsManage gm
                      ON gm.GoodsManageIdx = pm.GoodsManageIdx
                    JOIN phi.ClientCustomerManage ccm
                      ON ccm.ClientCustomerManageIdx = pm.ClientCustomerManageIdx
                    JOIN phi.ServiceCompanyManage scm
                      ON scm.ServiceCompanyManageIdx = ccm.ServiceCompanyManageIdx
               LEFT JOIN pay.RefundManage rm
                      ON rm.PayOrderIdx = pm.PayOrderIdx
                   WHERE gm.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
                     AND (pm.OrderStatus = 1 OR (rm.RefundType IS NOT NULL AND pm.OrderStatus = 9))
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                $orderType = '';
                if ($item['OrderType'] === '2') {
                    $orderType = "자동";
                } elseif ($item['OrderType'] === '3') {
                    $orderType = "수동";
                }

                if (!$item['RefundType']) {
                    $orderStatus = "결제완료";
                    $orderAmount = $item['OrderAmount'];
                } else {
                    $orderStatus = "결제취소";
                    if ($item['OrderStatus'] === '9'){
                        $orderStatus = "결제취소(DB오류)";
                    }
                    $orderStatus .= $item['RefundType'] === 'STSC' ? ' - 전체취소' : ' - 부분취소';
                    $orderAmount = "-{$item['OrderAmount']}";
                }

                $data[] = [
                    // 테이블 값
                    'PayOrderIdx' => $item['PayOrderIdx'],
                    'PayOrderCode' => $item['PayOrderCode'],
                    'RelatedPayOrderIdx' => $item['RelatedPayOrderIdx'] ?? '',
                    'PayMethod' => $item['PayMethod'],
                    'GoodsManageIdx' => $item['GoodsManageIdx'],
                    'GoodsName' => $item['GoodsName'],
                    'OrderAmount' => $orderAmount,
                    'ServiceCompanyName' => $item['ServiceCompanyName'],
                    'CompanyName' => $item['CompanyName'] ?? '',
                    'BuyerName' => $item['BuyerName'],
                    'BuyerPhone' => $item['BuyerPhone'],
                    'ApprovedDatetime' => $item['ApprovedDatetime'] ?? '',
                    'OrderStatus' => $orderStatus,
                    'OrderType' => $orderType,
                ];
            }

            $this->data['data'] = $data;
            $this->conn = null;

            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 상담사별 티켓 잔량 조회
    function searchTicketData($param) : array
    {
        $this->desc = 'searchTicketData';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $sql = "SELECT COUNT(itm.TicketManageIdx) AS IssuedCount
                          , ccm.ClientCustomerManageIdx, ccm.ClientCustomerName, ccm.CCGroup, ccm.ClientCustomerCode
                          , ccm.CCTel
                          , sm.ServiceCompanyName
                          , tm.TicketManageIdx
                     FROM phi.ClientCustomerManage AS ccm
                     JOIN phi.ServiceCompanyManage AS sm
                       ON sm.ServiceCompanyManageIdx = ccm.ServiceCompanyManageIdx
                     JOIN phi.TicketManage AS tm
                       ON tm.ClientCustomerManageIdx = ccm.ClientCustomerManageIdx
                LEFT JOIN phi.IssuedTicketManage AS itm
                       ON itm.TicketManageIdx = tm.TicketManageIdx
                    WHERE ccm.ClientCustomerManageIdx = :clientCustomerManageIdx
                      AND tm.TicketType = 2
                      AND ccm.IsUse = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':clientCustomerManageIdx',$param['clientCustomerManageIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $data = [];
            $row = $stmt->fetch();
            if($row) {
                $data = [
                    'clientCustomerManageIdx' => (int)$row['ClientCustomerManageIdx'],
                    'clientCustomerName'      => $row['ClientCustomerName'],
                    'cCGroup'                 => $row['CCGroup'],
                    'cCTel'                   => $row['CCTel'],
                    'clientCustomerCode'      => $row['ClientCustomerCode'],
                    'serviceCompanyName'      => $row['ServiceCompanyName'],
                    'oldIssuedCount'          => (int)$row['IssuedCount'],
                    'ticketManageIdx'         => (int)$row['TicketManageIdx'],
                ];
            }
            $this->data = $data;

            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    //상담사관리::상담사 개별 등록
    function registConsultant($param) : array
    {
        $this->desc = 'registConsultant';
        try {
            // 계약사 식별자
            $serviceCompanyManageIdx = $param['serviceCompanyManageIdx'];

            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $sql = "SELECT ClientCustomerManageIdx
                    FROM phi.ClientCustomerManage
                    WHERE ServiceCompanyManageIdx = :serviceCompanyManageIdx
                    AND ProductGroupIdx = :productGroupIdx
                    AND Depth = 1
                    AND IsUse = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':serviceCompanyManageIdx', $serviceCompanyManageIdx, $this->conn::PARAM_INT);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            // 부모 거래처 식별자
            $parentClientCustomerManageIdx = $stmt->fetch()['ClientCustomerManageIdx'];
            if(!$parentClientCustomerManageIdx) {
                throw new \Exception("질병예측검진권에 등록된 계약사가 아닙니다. 개발팀에 문의하세요","403");
            }

            $sql ="SELECT ClientCustomerCode
                   FROM phi.ClientCustomerManage
                   WHERE ClientCustomerName = :clientCustomerName
                    AND CCTel = :cCTel";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':clientCustomerName', $param['clientCustomerName'], $this->conn::PARAM_STR);
            $stmt->bindValue(':cCTel', $param['cCTel'], $this->conn::PARAM_STR);
            $stmt->execute();

            $isExist = $stmt->fetch();
            if($isExist) {
                throw new \Exception("상담사 중복 등록 - 계정 : ".$isExist['ClientCustomerCode'], "404");
            }

            $item = [
                'serviceCompanyManageIdx' => (int)$serviceCompanyManageIdx,
                'productGroupIdx'         => (int)$param['gIdx'],
                'clientCustomerName'      => $param['clientCustomerName'],
                'parentClientCustomerIdx' => (int)$parentClientCustomerManageIdx,
                'depth'                   => 2,
                'category'                => $param['category'],
                'cCGroup'                 => $param['cCGroup'],
                'cCTel'                   => $param['cCTel'],
                'cCManager'               => $param['clientCustomerName'],
                'latestAdminIP'           => $_SERVER['REMOTE_ADDR'],
            ];

            if(!isset($param['clientCustomerManageIdx'])) {
                // generate id
                $item['clientCustomerCode'] = $this->generateClientCode($param['gIdx']);

                // generate qrurl :: TODO// 상담사는 qrUrl이 필요없나?
                /*$orgUrl = "https://ds.genocorebs.com/phi/?hCode=" . $item['clientCustomerCode'];
                $result = (new NaverShortUrl())->getResult(['url' => $orgUrl]);
                if ($result['code'] !== 200) {
                    throw new \Exception("URL 생성에 실패하였습니다.", "400");
                }
                $response = json_decode($result['response'], true);
                $shortUrl = $response['result']['url'];
                if (!$shortUrl) {
                    throw new \Exception("URL 생성에 실패하였습니다.", 400);
                }

                $item['qRurl'] = "{$shortUrl}.qr";*/
            } else {
                $item['modDatetime'] = date('Y-m-d H:i:s');
            }

            $table = "phi.ClientCustomerManage";
            $idx = isset($param['clientCustomerManageIdx']) ? ['clientCustomerManageIdx' => (int)$param['clientCustomerManageIdx']] : [];

            $returnIdx = $this->insertUpdate($idx, $table, $item);
            if($returnIdx) {
                $clientCustomerManageIdx = $returnIdx;
            } else {
                $clientCustomerManageIdx = isset($param['clientCustomerManageIdx']) ? (int)$param['clientCustomerManageIdx'] : '';
            }

            if(!$clientCustomerManageIdx) {
                throw new \Exception('not exist clientCustomerManageIdx', '500');
            } else {
                // 무료 티켓 지급
                if(isset($param['serveCount'])) {
                    $serveCount = (int)$param['serveCount'];
                    if($serveCount > 0) {
                        $table = "phi.TicketManage";
                        $item = [
                            'ticketType' => 2,
                            'clientCustomerManageIdx' => $clientCustomerManageIdx,
                        ];
                        $sql = "SELECT TicketManageIdx FROM phi.TicketManage
                                 WHERE ClientCustomerManageIdx = ".$clientCustomerManageIdx. " AND TicketType = 2";
                        $stmt = $this->conn->query($sql);
                        $ticketIdx = $stmt->fetch();

                        // 티켓 meta 갱신
                        if(!$ticketIdx) {
                            $ticketIdx = $this->insertUpdate([],$table, $item);
                        } else {
                            $ticketIdx = (int)$ticketIdx['TicketManageIdx'];
                            $item['modDatetime'] = date('Y-m-d H:i:s');
                            $this->insertUpdate(['ticketManageIdx'=>$ticketIdx], $table, $item);
                        }

                        // 티켓 지급
                        $table = "phi.IssuedTicketManage";
                        $items = [];
                        for($i=0;$i<$serveCount;$i++) {
                            $items[] = [
                                'ticketManageIdx' => $ticketIdx,
                                'clientCustomerManageIdx' => $clientCustomerManageIdx,
                            ];
                        }
                        $this->bulkInsertUpdate([], $table, $items);
                    }
                }
            }
            $this->msg = "상담사 정보가 등록되었습니다.";
            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    //상담사 상태 업데이트
    function updateIsActiveClient($param) : array
    {
        $this->desc = 'updateIsActiveClient';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $idx = ['clientCustomerManageIdx' => (int)$param['idx']];
            $table = 'phi.ClientCustomerManage';
            $value = $param['key'] === 'isActive' ? (int)$param['value'] : $param['value'];
            $item = [
                $param['key'] => $value,
                'modDatetime' => date('Y-m-d H:i:s'),
            ];
            $this->insertUpdate($idx, $table, $item);
            $this->msg = "사용여부가 변경되었습니다.";
            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }


    }

    // 엑셀 데이터 조회 :: 상담사 리스트
    function consultantData($param) : array
    {
        $this->desc = 'consultantData';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $sql = "SELECT
                          ccm.RegDatetime, ccm.ModDatetime, ccm.CCGroup, ccm.CCManager, ccm.CCTel
                        , ccm.ClientCustomerManageIdx, ccm.ClientCustomerCode, ccm.ClientCustomerName
                        , scm.ServiceCompanyName, ccm.ProductGroupIdx, IF(ccm.IsActive = b'1', 'Y','N') AS IsActive
                        , cdm.RegistrationPath
                     FROM
                          phi.ClientCustomerManage AS ccm
                     JOIN phi.ServiceCompanyManage AS scm
                       ON scm.ServiceCompanyManageIdx = ccm.ServiceCompanyManageIdx
                LEFT JOIN phi.ClientCustomerDetailManage AS cdm
                       ON cdm.ClientCustomerManageIdx = ccm.ClientCustomerManageIdx
                    WHERE ccm.ProductGroupIdx = :productGroupIdx
                      AND ccm.Depth = 2
                ORDER BY ccm.RegDatetime DESC";

            $data = [];
            // 최근 상태 조회
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $pageUrl = 'https://ds.genocorebs.com';
            if(isDev) {
                $pageUrl = 'http://tds.genocorebs.com';
            }
            while ($item = $stmt->fetch()) {
                $data[$item['ClientCustomerManageIdx']] = [
                    // 테이블 값
                    'clientCustomerCode' => $item['ClientCustomerCode'],
                    'regDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                    'modDatetime' => substr($item['ModDatetime'], 0, 10) ?? '',
                    'registrationPath' => $item['RegistrationPath'],
                    'serviceCompanyName' => $item['ServiceCompanyName'],
                    'cCGroup' => $item['CCGroup'],
                    'cCManager' => $item['CCManager'],
                    'cCTel' => $item['CCTel'],
                    'ticketInfo' => [],
                    'payTicket' => 0,
                    'usedPayTicket' => 0,
                    'freeTicket' => 0,
                    'usedFreeTicket' => 0,
                    'clientUrl' => $pageUrl.'/phi/?hCode='.$item['ClientCustomerCode'],
                    'isActive' => $item['IsActive'],
                ];
            }

            $sql = "SELECT
                           TicketManageIdx, ClientCustomerManageIdx, TicketType
                      FROM phi.TicketManage";
            $stmt = $this->conn->query($sql);
            while($row = $stmt->fetch()) {
                if(!isset($data[$row['ClientCustomerManageIdx']])) {
                    continue;
                }
                $data[$row['ClientCustomerManageIdx']]['ticketInfo'][$row['TicketManageIdx']] = [
                    'ticketType' => $row['TicketType'],
                    'issuedCount'      => 0,
                    'expiredCount'      => 0,
                ];
            }

            // 발행된 티켓 카운팅
            $sql = "SELECT
                          tm.ClientCustomerManageIdx, tm.TicketManageIdx, COUNT(itm.TicketManageIdx) AS IssuedTicketCount
                     FROM phi.TicketManage AS tm
                LEFT JOIN phi.IssuedTicketManage AS itm
                       ON itm.TicketManageIdx = tm.TicketManageIdx
                 GROUP BY tm.ClientCustomerManageIdx, tm.TicketManageIdx";
            $stmt = $this->conn->query($sql);
            while($row = $stmt->fetch()) {
                if(!isset($data[$row['ClientCustomerManageIdx']])) {
                    continue;
                }
                $data[$row['ClientCustomerManageIdx']]['ticketInfo'][$row['TicketManageIdx']]['issuedCount'] = (int)$row['IssuedTicketCount'];
            }

            // 사용된 티켓 카운팅
            $sql = "SELECT
                          tm.ClientCustomerManageIdx, tm.TicketManageIdx, COUNT(etm.TicketManageIdx) AS ExpiredTicketCount
                      FROM phi.TicketManage AS tm
                 LEFT JOIN phi.ExpiredTicketManage AS etm
                        ON etm.TicketManageIdx = tm.TicketManageIdx
                     WHERE etm.ExpiredType IN (1,2) #사용완료, 만료
                  GROUP BY tm.ClientCustomerManageIdx, tm.TicketManageIdx";
            $stmt = $this->conn->query($sql);
            while($row = $stmt->fetch()) {
                if(!isset($data[$row['ClientCustomerManageIdx']])) {
                    continue;
                }
                $data[$row['ClientCustomerManageIdx']]['ticketInfo'][$row['TicketManageIdx']]['expiredCount'] = (int)$row['ExpiredTicketCount'];
            }

            foreach ($data as $key => $value) {
                $data[$key]['registrationPath'] = $data[$key]['registrationPath'] === '2' ? '자동' : '수동';
                if($value['ticketInfo']) {
                    foreach ($value['ticketInfo'] as $k => $v) {
                        if($v['ticketType'] === '1') {
                            // pay
                            $data[$key]['usedPayTicket'] += (int)$v['issuedCount'];
                            if($v['issuedCount']) {
                                $data[$key]['payTicket'] += (int)$v['issuedCount'];
                            }
                            if($v['expiredCount']) {
                                $data[$key]['payTicket'] += (int)$v['expiredCount'];
                            }
                        } else {
                            // free
                            $data[$key]['usedFreeTicket'] += (int)$v['issuedCount'];
                            if($v['issuedCount']) {
                                $data[$key]['freeTicket'] += (int)$v['issuedCount'];
                            }
                            if($v['expiredCount']) {
                                $data[$key]['freeTicket'] += (int)$v['expiredCount'];
                            }
                        }
                    }
                }
                if($value['cCTel'] !== '') {
                    // 지역번호, 길이에 따른 전화번호 가공
                    if(substr($value['cCTel'],0,2) === '02') {
                        $offset = 2;
                    }else {
                        $offset = 3;
                    }
                    if(mb_strlen(substr($value['cCTel'], $offset)) < 8) {
                        $tel = substr_replace($value['cCTel'],'-',$offset+3,0);
                    } else {
                        $tel = substr_replace($value['cCTel'],'-',$offset+4,0);
                    }
                    $data[$key]['cCTel'] = substr_replace($tel,')',$offset,0);
                }
                unset($data[$key]['ticketInfo']);
            }

            $this->conn = null;
            return $data;

        } catch (\Exception $e) {
            throw $e;
        }
    }


    // 상담사 리스트 조회
    function consultantList($param) : array
    {
        $this->desc = 'consultantList';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['scm.ServiceCompanyName','ccm.CCGroup','ccm.ClientCustomerName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            if(isset($param['startDate'])) {
                if($param['startDate'] !== '' && $param['endDate'] !== '') {
                    $addSql .= " AND ccm.RegDatetime BETWEEN '".$param['startDate']." 00:00:00' AND '".$param['endDate']." 23:59:59' ";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, ccm.RegDatetime DESC ";
            } else {
                $orderSql .= ' ccm.RegDatetime DESC ';
            }


            $sql = "SELECT
                          ccm.RegDatetime, ccm.ModDatetime, ccm.CCGroup, ccm.CCManager, ccm.CCTel
                        , ccm.ClientCustomerManageIdx, ccm.ClientCustomerCode, ccm.ClientCustomerName
                        , scm.ServiceCompanyName, ccm.ProductGroupIdx, IF(ccm.IsActive = b'1', 'Y','N') AS IsActive
                        , cdm.RegistrationPath
                     FROM
                          phi.ClientCustomerManage AS ccm
                     JOIN phi.ServiceCompanyManage AS scm
                       ON scm.ServiceCompanyManageIdx = ccm.ServiceCompanyManageIdx
                LEFT JOIN phi.ClientCustomerDetailManage AS cdm
                       ON cdm.ClientCustomerManageIdx = ccm.ClientCustomerManageIdx
                    WHERE ccm.ProductGroupIdx = :productGroupIdx
                      AND ccm.Depth = 2
                    {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();

            while ($item = $stmt->fetch()) {
                $data[$item['ClientCustomerManageIdx']] = [
                    // 테이블 값
                    'productGroupIdx' => $item['ProductGroupIdx'],
                    'registrationPath' => $item['RegistrationPath'],
                    'clientCustomerName' => $item['ClientCustomerName'],
                    'regDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                    'modDatetime' => substr($item['ModDatetime'], 0, 10) ?? '',
                    'cCGroup' => $item['CCGroup'],
                    'cCManager' => $item['CCManager'],
                    'cCTel' => $item['CCTel'],
                    'serviceCompanyName' => $item['ServiceCompanyName'],
                    'clientCustomerCode' => $item['ClientCustomerCode'],
                    'isActive' => $item['IsActive'],
                    'ticketInfo' => [],
                ];
            }

            $sql = "SELECT
                           TicketManageIdx, ClientCustomerManageIdx, TicketType
                      FROM phi.TicketManage";
            $stmt = $this->conn->query($sql);
            while($row = $stmt->fetch()) {
                if(!isset($data[$row['ClientCustomerManageIdx']])) {
                    continue;
                }
                $data[$row['ClientCustomerManageIdx']]['ticketInfo'][$row['TicketManageIdx']] = [
                    'ticketType' => $row['TicketType'],
                    'issuedCount'      => 0,
                    'expiredCount'      => 0,
                ];
            }

            // 발행된 티켓 카운팅
            $sql = "SELECT
                          tm.ClientCustomerManageIdx, tm.TicketManageIdx, COUNT(itm.TicketManageIdx) AS IssuedTicketCount
                     FROM phi.TicketManage AS tm
                LEFT JOIN phi.IssuedTicketManage AS itm
                       ON itm.TicketManageIdx = tm.TicketManageIdx
                 GROUP BY tm.ClientCustomerManageIdx, tm.TicketManageIdx";
            $stmt = $this->conn->query($sql);
            while($row = $stmt->fetch()) {
                if(!isset($data[$row['ClientCustomerManageIdx']])) {
                    continue;
                }
                $data[$row['ClientCustomerManageIdx']]['ticketInfo'][$row['TicketManageIdx']]['issuedCount'] = (int)$row['IssuedTicketCount'];
            }

            // 사용된 티켓 카운팅
            $sql = "SELECT
                          tm.ClientCustomerManageIdx, tm.TicketManageIdx, COUNT(etm.TicketManageIdx) AS expiredTicketCount
                      FROM phi.TicketManage AS tm
                 LEFT JOIN phi.ExpiredTicketManage AS etm
                        ON etm.TicketManageIdx = tm.TicketManageIdx
                     WHERE etm.ExpiredType IN (1,2) #사용완료, 만료
                  GROUP BY tm.ClientCustomerManageIdx, tm.TicketManageIdx";
            $stmt = $this->conn->query($sql);
            while($row = $stmt->fetch()) {
                if(!isset($data[$row['ClientCustomerManageIdx']])) {
                    continue;
                }
                $data[$row['ClientCustomerManageIdx']]['ticketInfo'][$row['TicketManageIdx']]['expiredCount'] = (int)$row['expiredTicketCount'];
            }

            // 회사 식별자 조회
            $sql = "SELECT
                          scm.ServiceCompanyManageIdx AS `value`, scm.ServiceCompanyName AS `text`
                      FROM phi.ServiceCompanyManage AS scm
                      JOIN phi.GoodsManage AS gm
                        ON scm.ServiceCompanyManageIdx = gm.ServiceCompanyManageIdx
                      JOIN phi.ClientCustomerManage as ccm
                        ON ccm.ServiceCompanyManageIdx = scm.ServiceCompanyManageIdx
                       AND ccm.Depth = 1
                    WHERE scm.IsContract = b'1'
                      AND ccm.ProductGroupIdx = ".$param['gIdx']."
                 GROUP BY ccm.ClientCustomerManageIdx";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];

            $this->data['data'] = $data;
            $this->data['select::serviceCompany'] = $row;
            $this->conn = null;

            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 굿즈관리 삭제
    function deleteGoods($param) : array
    {
        $this->desc = "model::deleteGoods";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['goodsManageIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            // 해당 goodsManageIdx 정보 조회
            $sql = "SELECT GoodsManageIdx
                      FROM phi.GoodsManage
                     WHERE GoodsManageIdx = :goodsManageIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':goodsManageIdx', $param['goodsManageIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $goodsManageInfo = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];
            if (!$goodsManageInfo) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $table = "phi.GoodsManage";
            $idx = [
                'goodsManageIdx' => $param['goodsManageIdx']
            ];
            $item = [
                'isUse' => b'0',
                'modDatetime' => date('Y-m-d H:i:s'),
            ];

            $this->insertUpdate($idx, $table, $item);

            $this->msg = "goodsManageIdx 삭제완료";


            return $this->response();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 굿즈관리 등록
    function registGoods($param) : array
    {
        $this->desc = "model::registGoods";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['goodsManageType'], $param['serviceCompanyManageIdx'], $param['salesPrice'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                !in_array($param['goodsManageType'], ['edit', 'register'])
                || !preg_match($this->pattern['num'], $param['salesPrice'])
                || ($param['goodsName'] && !preg_match($this->pattern['all'], $param['goodsName']))
            ) {
                throw new \Exception('파라미터가 올바르지 않습니다.', "400");
            }

            $sql = "SELECT ServiceCompanyName, ServiceCompanyId
                      FROM phi.ServiceCompanyManage
                     WHERE ServiceCompanyManageIdx = :serviceCompanyManageIdx
                       AND IsContract = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':serviceCompanyManageIdx', $param['serviceCompanyManageIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $serviceCompanyInfo = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];
            if (!$serviceCompanyInfo) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            if ($param['goodsManageType'] === 'register') {
                // GoodsManage
                $table = "phi.GoodsManage";
                $item = [
                    'serviceCompanyManageIdx' => $param['serviceCompanyManageIdx'],
                    'productGroupIdx' => $param['gIdx'],
                    'goodsName' => $param['goodsName'],
                    'salesPrice' => $param['salesPrice'],
                ];
                $this->data['goodsManageIdx'] = $this->insertUpdate([], $table, $item);

                $this->msg = "goodsManageIdx 등록완료";
            }
            if ($param['goodsManageType'] === 'edit') {
                if (!isset($param['goodsManageIdx'])) {
                    throw new \Exception('필수 파라미터가 없습니다.', "404");
                }

                // 해당 goodsManageIdx 정보 조회
                $sql = "SELECT GoodsManageIdx
                          FROM phi.GoodsManage
                         WHERE GoodsManageIdx = :goodsManageIdx";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':goodsManageIdx', $param['goodsManageIdx'], $this->conn::PARAM_INT);
                $stmt->execute();
                $goodsManageInfo = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];
                if (!$goodsManageInfo) {
                    throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
                }

                // 해당 goodsManageIdx 결제 이력 체크
                $sql = "SELECT PayOrderIdx
                          FROM pay.PaymentManage
                         WHERE GoodsManageIdx = :goodsManageIdx";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':goodsManageIdx', $param['goodsManageIdx'], $this->conn::PARAM_INT);
                $stmt->execute();
                $payHistory = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];
                if (count($payHistory) > 0){
                    throw new \Exception('결제 이력이 존재하여 수정이 불가합니다.', "400");
                }

                $table = "phi.GoodsManage";
                $idx = [
                    'goodsManageIdx' => $param['goodsManageIdx']
                ];
                $item = [
                    'serviceCompanyManageIdx' => $param['serviceCompanyManageIdx'],
                    'productGroupIdx' => $param['gIdx'],
                    'goodsName' => $param['goodsName'],
                    'salesPrice' => $param['salesPrice'],
                    'modDatetime' => date('Y-m-d H:i:s'),
                ];

                $this->insertUpdate($idx, $table, $item);

                $this->msg = "goodsManageIdx 수정완료";
            }

            // ClientCustomerManage 부모 식별자 없을시 생성 (Depth = 1)
            $sql = "SELECT ClientCustomerManageIdx FROM phi.ClientCustomerManage
                    WHERE ServiceCompanyManageIdx = :serviceCompanyManageIdx
                      AND ProductGroupIdx = :productGroupIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':serviceCompanyManageIdx', $param['serviceCompanyManageIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $clientCustomerManageIdx = $stmt->fetch($this->conn::FETCH_COLUMN) ?? 0;
            if (!$clientCustomerManageIdx) {
                $table = "phi.ClientCustomerManage";
                $item = [
                    'serviceCompanyManageIdx' => $param['serviceCompanyManageIdx'],
                    'productGroupIdx' => $param['gIdx'],
                    'ClientCustomerCode' => $serviceCompanyInfo['ServiceCompanyId'],
                    'ClientCustomerName' => $serviceCompanyInfo['ServiceCompanyName'],
                    'Depth' => 1,
                ];
                $this->data['parentClientCustomerIdx'] = $this->insertUpdate([], $table, $item);
            }

            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 굿즈관리 조회(수정 Modal)
    function searchGoods($param) : array
    {
        $this->desc = "model::searchGoods";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['goodsManageIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            // 해당 goodsManageIdx 결제 이력 체크
            if ($param['searchType'] === 'edit') {
                $sql = "SELECT PayOrderIdx
                          FROM pay.PaymentManage
                         WHERE GoodsManageIdx = :goodsManageIdx";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':goodsManageIdx', $param['goodsManageIdx'], $this->conn::PARAM_INT);
                $stmt->execute();
                $payHistory = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];
                if (count($payHistory) > 0){
                    throw new \Exception('결제 이력이 존재하여 수정이 불가합니다.', "400");
                }
            }

            $sql = "SELECT
                        gm.RegDatetime, gm.GoodsManageIdx, gm.ServiceCompanyManageIdx,
                        gm.GoodsName, gm.SalesPrice, scm.ServiceCompanyName
                      FROM phi.GoodsManage gm
                      JOIN phi.ServiceCompanyManage scm
                        ON scm.ServiceCompanyManageIdx = gm.ServiceCompanyManageIdx
                     WHERE gm.GoodsManageIdx = :goodsManageIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':goodsManageIdx', $param['goodsManageIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch() ?? [];
            if (!$row) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $this->data = [
                'regDatetime' => substr($row['RegDatetime'], 0, 10),
                'goodsManageIdx' => $row['GoodsManageIdx'],
                'serviceCompanyManageIdx' => $row['ServiceCompanyManageIdx'],
                'serviceCompanyName' => $row['ServiceCompanyName'],
                'goodsName' => $row['GoodsName'],
                'salesPrice' => $row['SalesPrice'],
            ];

            return $this->response();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 굿즈관리 조회(결제경로 관리)
    function goodsList($param) : array
    {
        $this->desc = "model::goodsList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['scm.ServiceCompanyName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, gm.RegDatetime DESC ";
            } else {
                $orderSql .= ' gm.RegDatetime DESC ';
            }

            // 대상 전체 카운트
            $sql = "SELECT
                        gm.RegDatetime, gm.GoodsManageIdx, gm.ServiceCompanyManageIdx,
                        gm.GoodsName, gm.SalesPrice, scm.ServiceCompanyName
                    FROM phi.GoodsManage gm
                    JOIN phi.ServiceCompanyManage scm
                      ON scm.ServiceCompanyManageIdx = gm.ServiceCompanyManageIdx
                   WHERE gm.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
                     AND scm.IsContract = TRUE #사용처가 계약상태인지 확인 필요
                     AND gm.IsUse = TRUE
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                $data[] = [
                    // 테이블 값
                    'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                    'GoodsManageIdx' => $item['GoodsManageIdx'],
                    'ServiceCompanyManageIdx' => $item['ServiceCompanyManageIdx'],
                    'ServiceCompanyName' => $item['ServiceCompanyName'],
                    'GoodsName' => $item['GoodsName'],
                    'SalesPrice' => $item['SalesPrice'],
                ];
            }

            $sql = "SELECT
                        ServiceCompanyManageIdx AS `value`, ServiceCompanyName AS `text`
                    FROM phi.ServiceCompanyManage
                    WHERE IsContract = b'1'";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];

            $this->data['data'] = $data;
            $this->data['select::serviceCompany'] = $row;
            $this->conn = null;

            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 등록된 쿠폰 리스트 조회
    function registCouponList($param) : array
    {
        $this->desc = 'registCouponList';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }
            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['cm.CouponName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, cm.CouponManageIdx DESC ";

            } else {
                $orderSql .= ' cm.CouponManageIdx DESC';
            }

            $data = [];
            // 대상 전체 카운트
            $sql = "SELECT
                          cm.CouponManageIdx, cm.CouponType, cm.CouponCode, cm.CouponName, cm.DiscountMethod
                        , cm.DiscountAmount, cm.DiscountRate, cm.ServiceCompanyManageIdx, cm.ClientCustomerManageIdx
                        , cm.UseStartDate, cm.UseEndDate, cm.CouponStatus, cm.RegDatetime, cm.ModDatetime
                        , sm.ServiceCompanyName
                      FROM phi.CouponManage AS cm
                      JOIN phi.ServiceCompanyManage AS sm
                        ON sm.ServiceCompanyManageIdx = cm.ServiceCompanyManageIdx
                     WHERE cm.ProductGroupIdx = :productGroupIdx
                       AND cm.IsUse = b'1'
                          {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                $data[$item['CouponManageIdx']] = [
                    'couponManageIdx'         => $item['CouponManageIdx'],
                    'couponType'              => $item['CouponType'],
                    'couponCode'              => $item['CouponCode'],
                    'couponName'              => $item['CouponName'],
                    'discountMethod'          => $item['DiscountMethod'],
                    'discountAmount'          => $item['DiscountAmount'],
                    'discountRate'            => $item['DiscountRate'],
                    'serviceCompanyManageIdx' => $item['ServiceCompanyManageIdx'],
                    'serviceCompanyName'      => $item['ServiceCompanyName'],
                    'clientCustomerManageIdx' => $item['ClientCustomerManageIdx'],
                    'useStartDate'            => $item['UseStartDate'],
                    'useEndDate'              => $item['UseEndDate'],
                    'couponStatus'            => $item['CouponStatus'],
                    'regDatetime'             => substr($item['RegDatetime'], 0, 10) ?? '',
                    'modDatetime'             => substr($item['ModDatetime'], 0, 10) ?? '',
                ];
            }

            // 회사 식별자 조회
            $sql = "SELECT
                          scm.ServiceCompanyManageIdx AS `value`, scm.ServiceCompanyName AS `text`
                      FROM phi.ServiceCompanyManage AS scm
                      JOIN phi.GoodsManage AS gm
                        ON scm.ServiceCompanyManageIdx = gm.ServiceCompanyManageIdx
                      JOIN phi.ClientCustomerManage as ccm
                        ON ccm.ServiceCompanyManageIdx = scm.ServiceCompanyManageIdx
                       AND ccm.Depth = 1
                    WHERE scm.IsContract = b'1'
                      AND ccm.ProductGroupIdx = ".$param['gIdx']."
                 GROUP BY ccm.ClientCustomerManageIdx";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];

            $this->data['data'] = $data;
            $this->data['select::serviceCompany'] = $row;

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 상담사 계정 생성 ** recursive 주의 **
    function generateClientCode($serviceIdx, $i = 0): string
    {
        try {
            if($i > 10) {
                throw new Exception('create error ID', '503');
            }

            switch ($serviceIdx) {
                case '6' :
                    $idHeader = 'icg_';
                    break;
                case '4' :
                    $idHeader = 'tst_';
                    break;
                case '7' :
                    $idHeader = 'kfg_';
                    break;
                default :
                    $idHeader = 'gen_';
            }

            $rand_str = bin2hex(random_bytes(4));
            $id = $idHeader.$rand_str;

            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            // 중복 id 확인
            $sql = "SELECT ClientCustomerCode FROM phi.ClientCustomerManage WHERE ClientCustomerCode = '".$id."'";
            $stmt = $this->conn->query($sql);
            $isExist = $stmt->fetch();
            // id 중복시 재귀
            if($isExist) {
                $i++;
                return $this->generateClientCode($serviceIdx, $i);
            } else {
                return $id;
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 쿠폰 생성 ** recursive 주의 **
    function generateCoupon($serviceIdx, $i=0): string
    {
        try {
            if($i > 10) {
                throw new \Exception('create error COUPON', '503');
            }

            switch ($serviceIdx) {
                case '6' :
                    $cpnHeader = 'ICG';
                    break;
                case '4' :
                    $cpnHeader = 'TST';
                    break;
                case '7' :
                    $cpnHeader = 'KFG';
                    break;
                default :
                    $cpnHeader = 'GEN';
            }

            $rand_str = strtoupper(bin2hex(random_bytes(8)));
            $coupon = $cpnHeader.$rand_str;

            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            // 중복 coupon 확인
            $sql = "SELECT CouponCode FROM phi.CouponManage WHERE CouponCode = '".$coupon."'";
            $stmt = $this->conn->query($sql);
            $isExist = $stmt->fetch();
            // coupon 중복시 재귀
            if($isExist) {
                $i++;
                return $this->generateCoupon($serviceIdx, $i);
            } else {
                return $coupon;
            }

        } catch (\Exception $e) {
            throw $e;
        }

    }

    // 쿠폰 등록
    function couponRegist($param) : array
    {
        $this->desc = 'couponRegist';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $this->msg = '쿠폰 데이터가 변경되었습니다.';
            $this->conn->beginTransaction();

            $item = [];
            $item['couponType'] = $param['couponType'] ? (int)$param['couponType'] : 1;
            $item['couponName'] = $param['couponName'] ? mb_substr($param['couponName'],0,50) : '';
            $item['discountMethod'] = $param['discountMethod'] ? (int)$param['discountMethod'] : 1;
            $item['discountAmount'] = 0;
            $item['discountRate'] = 0;
            if($item['discountMethod']  === 2) {
                //할인가
                $item['discountAmount'] = (int)$param['amount'];
            } else {
                //할인율
                $item['discountRate'] = (int)$param['amount'];
            }
            $item['serviceCompanyManageIdx'] = $param['parentClientCustomerIdx'] ? (int)$param['parentClientCustomerIdx'] : '';
            $item['clientCustomerManageIdx'] = isset($param['consultantId']) ? (int)$param['clientCustomerManageIdx'] : 'null';
            $item['useStartDate'] = $param['useStartDate'] ? date('Y-m-d', strtotime($param['useStartDate'])) : '';
            $item['useEndDate'] = $param['useEndDate'] ? date('Y-m-d', strtotime($param['useEndDate'])) : '';
            $item['couponStatus'] = $param['couponStatus'] ? (int)$param['couponStatus'] : 1;
            $item['productGroupIdx'] = (int)$param['gIdx'];

            $table = "phi.CouponManage";
            $idx = isset($param['couponManageIdx']) ? ['couponManageIdx' => (int)$param['couponManageIdx']] : [];

            if(isset($param['couponManageIdx'])) {
                $item['modDatetime'] = date('Y-m-d H:i:s');
            } else {
                $item['couponCode'] = $this->generateCoupon($param['gIdx']);
            }
            $couponManageIdx = $this->insertUpdate($idx, $table, $item);

            if($couponManageIdx > 0) {
                $table = 'phi.IssuedCouponManage';
                $couponItem = [
                    'couponManageIdx' => $couponManageIdx,
                    'couponCode' => $item['couponCode'],
                    'clientCustomerManageIdx' => $item['clientCustomerManageIdx'],
                ];

                $couponManageIdx = $this->insertUpdate([], $table, $couponItem);
                $this->data['couponManageIdx'] = $couponManageIdx;
                $this->msg = '쿠폰이 발행되었습니다.';
            }

            $this->conn->commit();
            $this->conn = null;

            return $this->response();

        } catch (\Exception $e) {
            $this->conn->rollBack();
            $this->conn = null;

            throw $e;
        }
    }

    //상담사 조회
    function searchConsultantId($param) : array
    {
        $this->desc = 'searchConsultantId';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $sql = " SELECT ClientCustomerManageIdx, ClientCustomerName
                       FROM phi.ClientCustomerManage
                      WHERE ServiceCompanyManageIdx = :parentClientCustomerManageIdx
                        AND ClientCustomerCode  = BINARY(:clientCustomerCode)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':parentClientCustomerManageIdx',$param['parentClientCustomerManageIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':clientCustomerCode', $param['clientCustomerCode']);
            $stmt->execute();

            $row = $stmt->fetch($this->conn::FETCH_ASSOC);

            $clientCustomerManageIdx = '';
            $clientCustomerName = '';
            if($row) {
                $clientCustomerManageIdx = $row['ClientCustomerManageIdx'];
                $clientCustomerName = $row['ClientCustomerName'];
            }

            $this->data = [
                'ClientCustomerManageIdx' => $clientCustomerManageIdx,
                'ClientCustomerName'      => $clientCustomerName,
            ];

            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    //보험할당 이력
    function insureIbHistory($param) : array
    {
        $this->desc = 'model::insureIbHistory';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            // 할당 기준 조회
            $sql = " SELECT   scm.ServiceCompanyName
                            , asmh.ServiceCompanyManageIdx, asmh.TotalServeLimit, asmh.RegDatetime
                       FROM phi.`AllocationServeManageHistory` AS asmh
                       JOIN phi.ServiceCompanyManage AS scm
                		 ON scm.ServiceCompanyManageIdx = asmh.ServiceCompanyManageIdx
                      WHERE asmh.ProductGroupIdx = ".$param['gIdx']."
                        AND scm.IsContract = b'1'
                   ORDER BY asmh.RegDatetime ASC";
            $stmt = $this->conn->query($sql);
            $data = [];
            while($row = $stmt->fetch()) {
                // 총 제공량(최근 설정)
                $data[$row['ServiceCompanyManageIdx']]['ServiceCompanyName'] = $row['ServiceCompanyName'];
                $data[$row['ServiceCompanyManageIdx']]['TotalServeLimit'] = $row['TotalServeLimit'];
                // 할당 설정 일자(최근)
                $data[$row['ServiceCompanyManageIdx']]['RegDatetime'] = $row['RegDatetime'];
                // 총 제공량(누적)
                if(isset($data[$row['ServiceCompanyManageIdx']]['AccumalServeCount'])) {
                    $data[$row['ServiceCompanyManageIdx']]['AccumalServeCount'] = $data[$row['ServiceCompanyManageIdx']]['AccumalServeCount'] + $row['TotalServeLimit'];
                } else {
                    $data[$row['ServiceCompanyManageIdx']]['AccumalServeCount'] = $row['TotalServeLimit'];
                    $data[$row['ServiceCompanyManageIdx']]['AccumalAllocationCount'] = 0;
                    $data[$row['ServiceCompanyManageIdx']]['LatestAllocationCount'] = 0;
                }
            }
            $total = count($data);
            $this->setPagination($total, $param);
            // 할당량 조회
            $sql = "  SELECT
                            mam.OrderIdx, mam.ServiceCompanyManageIdx, mam.RegDatetime
                        FROM phi.MemberAllocationManage AS mam
                        WHERE mam.ProductGroupIdx = ".$param['gIdx'];
            $stmt = $this->conn->query($sql);
            while($row = $stmt->fetch()) {
                if($row['RegDatetime'] >= $data[$row['ServiceCompanyManageIdx']]['RegDatetime']) {
                    // 최근 할당량
                    $data[$row['ServiceCompanyManageIdx']]['LatestAllocationCount'] += 1;
                }
                // 총 누적 할당량
                $data[$row['ServiceCompanyManageIdx']]['AccumalAllocationCount'] += 1;
            }
            $this->data['data'] = $data;
            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 보험상담결과 엑셀 업로드
    function uploadConsultingResult($param): array
    {
        $this->desc = 'uploadConsultingResult';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param[0]['consultingFile'])) {
                throw new \Exception("필수 파라미터들이 없습니다.", "404");
            }

            $serverFilename = $param[0]['consultingFile']['tmp_name'];
            $pcFilename = $param[0]['consultingFile']['name'];

            $spreadsheet = new SpreadsheetFactory();
            $result = $spreadsheet->readSheet($serverFilename, $pcFilename);
            if ($result['code'] !== 200) {
                throw new \Exception('read error', 400);
            }

            $spreadData = $result['data'];
            if (count($spreadData) < 1) {
                throw new \Exception("양식이 입력되지 않았습니다.", "401");
            }
            unset($spreadData[0]);

            $success = 0;
            $failure = 0;

            $csTable = "phi.ConsultingStatus";
            $icmTable = "phi.InsuranceContractManage";
            foreach ($spreadData as $value) {
                if (!array_filter($value)) {
                    continue;
                }

                if (!$value[1] || !$value[2] || !$value[4]) {
                    throw new \Exception("회원ID, 주문상품ID 및 거래처ID 입력은 필수입니다.", "401");
                }

                // ConsultingStatus UPDATE
                $csIdx = [
                    'memberManageIdx' => (int)$value[1],
                    'orderIdx' => (int)$value[2]
                ];

                if ($value[6] && $value[7] && $value[8]) {
                    $csItems = [
                        'consultantIdx' => (int)$value[6],
                        'consultantName' => $value[7],
                        'consultantFixDate' => date('Y-m-d', strtotime($value[8])),
                        'modDatetime' => date('Y-m-d H:i:s'),
                    ];
                } else {
                    $failure++;
                    continue;
                }

                if ($value[9] && $value[10]) {
                    $csItems['statusCode'] = trim($value[9]);
                    $csItems['consultDate1'] = date('Y-m-d H:i:s', strtotime($value[10]));

                    if ($value[11] && $value[12]) {
                        $csItems['statusCode'] .= trim($value[11]);
                        $csItems['consultDate2'] = date('Y-m-d H:i:s', strtotime($value[12]));

                        if ($value[13] && $value[14]) {
                            $csItems['statusCode'] .= trim($value[13]);
                            $csItems['consultDate3'] = date('Y-m-d H:i:s', strtotime($value[14]));
                        }
                    }

                    if (strlen($csItems['statusCode']) > 3) {
                        $failure++;
                        continue;
                    }
                }

                // InsuranceContractManage UPDATE
                $icmIdx = [];
                $icmItems = [];
                if ($value[15] && $value[16] && $value[17] && $value[18] && $value[19]) {
                    //유효한 Insurance인지 체크
                    $sql = "SELECT
                                im.InsuranceManageIdx
                            FROM phi.InsuranceManage pim
                            JOIN phi.InsuranceManage im
                              ON im.ParentItemIdx = pim.InsuranceManageIdx
                            JOIN phi.ServiceCompanyManage scm
                              ON scm.ServiceCompanyManageIdx = pim.ServiceCompanyManageIdx
                           WHERE scm.ServiceCompanyName = :serviceCompanyName
                             AND pim.ItemCode = :parentItemCode
                             AND im.ItemCode = :itemCode
                             AND pim.IsUse = b'1'
                             AND im.IsUse = b'1'";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':serviceCompanyName', $value[4], $this->conn::PARAM_INT);
                    $stmt->bindValue(':parentItemCode', $value[15]);
                    $stmt->bindValue(':itemCode', $value[16]);
                    $stmt->execute();

                    $row = $stmt->fetch($this->conn::FETCH_ASSOC);
                    $insuranceManageIdx = $row['InsuranceManageIdx'] ?? 0;
                    if ($insuranceManageIdx) {
                        $icmIdx = [
                            'memberManageIdx' => (int)$value[1],
                            'orderIdx' => (int)$value[2],
                            'insuranceManageIdx' => (int)$insuranceManageIdx
                        ];

                        $icmItems = [
                            'memberManageIdx' => (int)$value[1],
                            'orderIdx' => (int)$value[2],
                            'insuranceManageIdx' => (int)$insuranceManageIdx,
                            'monthlyPremium' => (int)$value[17],
                            'dueDay' => (int)$value[18],
                            'contractDate' => date('Y-m-d', strtotime($value[19])),
                        ];
                    }
                }

                $this->conn->beginTransaction();
                $this->insertUpdate($csIdx, $csTable, $csItems);
                if ($icmIdx) {
                    $this->insertDuplicate($icmIdx, $icmTable, $icmItems, '');
                }
                $this->conn->commit();
                $success++;
            }

            $this->data['success'] = $success;
            $this->data['failure'] = $failure;

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->conn = null;
            throw $e;
        }
    }

    // 보험상담결과 엑셀 다운로드
    function consultingResultDown($param): void
    {
        $this->desc = 'consultingResultDown';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $data = [];
            $sql = "SELECT
                        o.RegDatetime, o.MemberManageIdx, o.OrderIdx, m.Name,
                        scm.ServiceCompanyName, mts.IsComplete,
                        cs.ConsultantIdx, cs.ConsultantName, cs.ConsultantFixDate, cs.StatusCode,
                        cs.ConsultDate1, cs.ConsultDate2, cs.ConsultDate3, cs.PhiTransferDatetime,
                        pim.ItemCode AS ParentItemCode, pim.ItemName AS ParentItemName,
                        im.ItemCode, im.ItemName, icm.MonthlyPremium, icm.DueDay, icm.ContractDate
                    FROM phi.MemberAllocationManage mam
                    JOIN phi.ConsultingStatus cs
                      ON (cs.MemberManageIdx, cs.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
                    JOIN order.Order AS o
                      ON o.OrderIdx = mam.OrderIdx
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
                    JOIN phi.ServiceCompanyManage scm
                      ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
               LEFT JOIN phi.MemberTransferStatus mts
                      ON (mts.MemberManageIdx, mts.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
               LEFT JOIN phi.InsuranceContractManage icm
                      ON (icm.MemberManageIdx, icm.OrderIdx) = (mts.MemberManageIdx, mts.OrderIdx)
               LEFT JOIN phi.InsuranceManage im
                      ON im.InsuranceManageIdx = icm.InsuranceManageIdx
               LEFT JOIN phi.InsuranceManage pim
                      ON pim.InsuranceManageIdx = im.ParentItemIdx
                   WHERE mm.IsOut = b'0' #탈퇴회원 제외
                     AND tm.MemberIdx IS NULL
                     AND o.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
                     AND o.IsActive = b'1' #활성회원 선별
                     AND scm.ServiceCompanyManageIdx <> 4
                     AND scm.TransferMethodCode = 2 #수동전송인 거래처만 특정";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $statusCode = $item['StatusCode'] ? str_split($item['StatusCode']) : [];

                $data[$item['OrderIdx']] = [
                    // 기본정보
                    'regDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                    'memberManageIdx' => $item['MemberManageIdx'],
                    'orderIdx' => $item['OrderIdx'],
                    'name' => $item['Name'],
                    'serviceCompanyName' => $item['ServiceCompanyName'],
                    //TODO:: 수동전송일 경우, PhiTransferDatetime가 업데이트 되지 않음으로 항상 null 상태 -> 해당 부분 사업부가 인지하고 있는지 불명
                    'isSent' => $item['PhiTransferDatetime'] ? 'Y' : 'N',
                    // 수정필드
                    'consultantIdx' => $item['ConsultantIdx'],
                    'consultantName' => $item['ConsultantName'],
                    'consultantFixDate' => $item['ConsultantFixDate'],
                    'statusCode1' => $statusCode[0] ?? '',
                    'consultDate1' => $item['ConsultDate1'],
                    'statusCode2' => $statusCode[1] ?? '',
                    'consultDate2' => $item['ConsultDate2'],
                    'statusCode3' => $statusCode[2] ?? '',
                    'consultDate3' => $item['ConsultDate3'],
                    'parentItemCode' => $item['ParentItemCode'],
                    'itemCode' => $item['ItemCode'],
                    'monthlyPremium' => $item['MonthlyPremium'],
                    'dueDay' => $item['DueDay'],
                    'contractDate' => $item['ContractDate'],
                ];
            }

            $headers = ['신청일자', '회원ID', '주문상품ID', '이름', 'IB거래처', '질병결과지 제공', '상담자ID', '상담자', '상담배정일시', '1차상담', '1차상담일', '2차상담', '2차상담일', '3차상담', '3차상담일', '보험사코드', '보험상품코드', '월납보험료', '납기', '계약일'];

            $spreadsheet = new SpreadsheetFactory();
            $spreadsheet->downloadSheet($headers, $data, '수동전송_보험상담내역');

            $this->conn = null;
            exit;

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험상담결과 더보기 조회 (인포유 통신: RequestMemo)
    function searchConsultingResult($param): array
    {
        $this->desc = 'searchConsultingResult';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $this->data['phiTransferDatetime'] = $param['phiTransferDatetime'] ?? '';
            $this->data['consultantFixDate'] = $param['consultantFixDate'] ?? '';
            $this->data['consultDate1'] = $param['consultDate1'] ?? '';
            $this->data['consultDate2'] = $param['consultDate2'] ?? '';
            $this->data['consultDate3'] = $param['consultDate3'] ?? '';

            if (!isset($param['serviceCompanyIdx'], $param['name'], $param['phone'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            if (
                !preg_match($this->pattern['num'], $param['serviceCompanyIdx'])
                || !preg_match($this->pattern['all'], $param['name'])
                || !preg_match($this->pattern['num'], $param['phone'])
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            if (!isDev && (int)$param['serviceCompanyIdx'] === 5){
                $header = [
                    "mrkim_access: {$this->apiInfisKey}",
                    "Content-Type: application/json; charset=utf-8",
                ];

                $reqParam = [
                    'name' => $param['name'],
                    'phone' => substr($param['phone'], 0, 3) . '-' . substr($param['phone'], 3, 4) . '-' . substr($param['phone'], 7, 4),
                ];

                $result = $this->curl("GET", $this->apiInfisUrl, $header, $reqParam);
                if ($result['code'] !== 200) {
                    throw new \Exception('Infis 통신 실패', "400");
                }
                $response = json_decode($result['response'], true);
                $this->data['requestMemo'] = $response[0]['requestMemo'] ?? '';
            }

            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    //보험상담결과 조회 - 얼리큐
    function consultingResList($param): array
    {
        $this->desc = "model::consultingResList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['prm.CalcDate', 'm.Name', 'scm.ServiceCompanyName', 'cs.ConsultantName', 'pim.ItemName', 'im.ItemName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    if ($param['keyword'] === 'cs.phiTransferDatetime') {
                        switch ($param['value']) {
                            case 'Y':
                                $addSql .= " AND {$param['keyword']} IS NOT NULL";
                                break;
                            case 'N':
                                $addSql .= " AND {$param['keyword']} IS NULL";
                                break;
                        }
                    } else if (in_array($param['keyword'], ['cs.StatusCode1', 'cs.StatusCode2', 'cs.StatusCode3'])) {
                        switch ($param['value']) {
                            case 'A':
                            case '계약체결':
                                $statusCodeDef = 'A';
                                break;
                            case 'B':
                            case '종결':
                                $statusCodeDef = 'B';
                                break;
                            case 'C':
                            case '결번':
                                $statusCodeDef = 'C';
                                break;
                            case 'D':
                            case '상담거절':
                                $statusCodeDef = 'D';
                                break;
                            case 'E':
                            case '무응답':
                                $statusCodeDef = 'E';
                                break;
                            case 'F':
                            case '중복':
                                $statusCodeDef = 'F';
                                break;
                            case 'G':
                            case '부재':
                                $statusCodeDef = 'G';
                                break;
                            case 'H':
                            case '병력':
                                $statusCodeDef = 'H';
                                break;
                            case 'I':
                            case '통화예약':
                                $statusCodeDef = 'I';
                                break;
                            case 'J':
                            case '상담완료':
                                $statusCodeDef = 'J';
                                break;
                            case 'K':
                            case '방문약속':
                                $statusCodeDef = 'K';
                                break;
                            case 'L':
                            case '계약대기':
                                $statusCodeDef = 'L';
                                break;
                            case 'M':
                            case '상담':
                                $statusCodeDef = 'M';
                                break;
                            case 'N':
                            case '거절':
                                $statusCodeDef = 'N';
                                break;
                            case 'O':
                            case '보완':
                                $statusCodeDef = 'O';
                                break;
                            case 'P':
                            case '인수불가':
                                $statusCodeDef = 'P';
                                break;
                            case 'Q':
                            case '신청오류':
                                $statusCodeDef = 'Q';
                                break;
                            case 'Z':
                            case '기타':
                                $statusCodeDef = 'Z';
                                break;
                            default:
                                $statusCodeDef = '';
                                break;
                        }
                        $keyword = substr($param['keyword'], 0, -1);
                        $trial = substr($param['keyword'], -1);

                        if ($trial === '1') {
                            $statusCodeDef = "{$statusCodeDef}%";
                        } else if ($trial === '2') {
                            $statusCodeDef = "_{$statusCodeDef}%";
                        } else if ($trial === '3') {
                            $statusCodeDef = "__{$statusCodeDef}";
                        }

                        $addSql .= " AND {$keyword} LIKE '{$statusCodeDef}'";
                    } else {
                        $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                    }
                }
            }
            // 대상 전체 카운트
            $sql = "SELECT
                        prm.CalcDate, o.MemberManageIdx, o.OrderIdx,
                        m.Name, m.Phone, tm.MemberIdx AS TestMember,
                        scm.ServiceCompanyManageIdx, scm.ServiceCompanyName,
                        cs.ConsultantName, cs.StatusCode, cs.ConsultantFixDate,
                        cs.ConsultDate1, cs.ConsultDate2, cs.ConsultDate3, cs.PhiTransferDatetime,
                        pim.ItemName AS ParentItemName, im.ItemName,
                        icm.MonthlyPremium, icm.DueDay, icm.ContractDate
                    FROM phi.MemberAllocationManage mam
                    JOIN phi.PhiReportManage prm
                      ON (prm.MemberManageIdx, prm.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
                    JOIN phi.ConsultingStatus cs
                      ON (cs.MemberManageIdx, cs.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
                    JOIN order.Order AS o
                      ON o.OrderIdx = mam.OrderIdx
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
                    JOIN phi.ServiceCompanyManage scm
                      ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
                    JOIN phi.MemberTransferStatus mts
                      ON (mts.MemberManageIdx, mts.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
               LEFT JOIN phi.InsuranceContractManage icm
                      ON (icm.MemberManageIdx, icm.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
               LEFT JOIN phi.InsuranceManage im
                      ON im.InsuranceManageIdx = icm.InsuranceManageIdx
               LEFT JOIN phi.InsuranceManage pim
                      ON pim.InsuranceManageIdx = im.ParentItemIdx
                   WHERE mm.IsOut = b'0' #탈퇴회원 제외
                     AND o.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
                     AND o.IsActive = b'1' #활성회원 선별
                     AND prm.ReportType = 2
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql .= " ORDER BY prm.CalcDate DESC ";
            $sql .= " LIMIT :start, :entry ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $data[$item['OrderIdx']] = [
                    // 테이블 값
                    'CalcDate' => $item['CalcDate'],
                    'MemberManageIdx' => $item['MemberManageIdx'],
                    'OrderIdx' => $item['OrderIdx'],
                    'Name' => $item['Name'],
                    'Phone' => $item['Phone'],
                    'TestMember' => $item['TestMember'],
                    'ServiceCompanyManageIdx' => $item['ServiceCompanyManageIdx'],
                    'ServiceCompanyName' => $item['ServiceCompanyName'],
                    'ConsultantName' => $item['ConsultantName'],
                    'StatusCode' => $item['StatusCode'],
                    'ParentItemName' => $item['ParentItemName'],
                    'ItemName' => $item['ItemName'],
                    'MonthlyPremium' => $item['MonthlyPremium'],
                    'DueDay' => $item['DueDay'],
                    'ContractDate' => $item['ContractDate'],
                    // Modal 값
                    //TODO:: 수동전송일 경우, PhiTransferDatetime가 업데이트 되지 않음으로 항상 null 상태 -> 해당 부분 사업부가 인지하고 있는지 불명
                    'PhiTransferDatetime' => $item['PhiTransferDatetime'],
                    'ConsultantFixDate' => $item['ConsultantFixDate'],
                    'ConsultDate1' => $item['ConsultDate1'],
                    'ConsultDate2' => $item['ConsultDate2'],
                    'ConsultDate3' => $item['ConsultDate3'],
                ];
            }

            $this->data['data'] = $data;
            $this->conn = null;

            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험IB관리 더보기 옵션 조회
    function searchIbUserData($param): array
    {
        $this->desc = 'model::searchIbUserData';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['gIdx'], $param['orderIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            $sql = "SELECT
                        o.OrderIdx,
                        scm.TransferMethodCode,
                        mam.RegDatetime AS ClientRegDate,
                        mts.RegDatetime AS TransferRegDate,
                        cs.AppointmentDate, cs.AppointmentDay, cs.AppointmentHour
                     FROM phi.MemberManage AS mm
                     JOIN order.Order AS o
                       ON o.MemberManageIdx = mm.MemberManageIdx
                LEFT JOIN phi.MemberAllocationManage AS mam
                       ON mam.MemberManageIdx = mm.MemberManageIdx
                LEFT JOIN phi.ServiceCompanyManage AS scm
                       ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
                LEFT JOIN phi.MemberTransferStatus AS mts
                       ON mts.OrderIdx = mam.OrderIdx
                LEFT JOIN phi.ConsultingStatus AS cs
                       ON cs.MemberManageIdx = mm.MemberManageIdx
                      AND cs.OrderIdx = o.OrderIdx
                    WHERE mm.IsOut = b'0'
                      AND o.ProductGroupIdx = :productGroupIdx
                      AND o.IsActive = b'1'
                      AND o.OrderIdx = :orderIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $this->data = [
                    'TransferMethodCode' => $row['TransferMethodCode'] ?? '',
                    'ClientRegDate' => $row['ClientRegDate'] ? substr($row['ClientRegDate'], 0, 10) : '',
                    'TransferRegDate' => $row['TransferRegDate'] ? substr($row['TransferRegDate'], 0, 10) : '',
                    'AppointmentDate' => $row['AppointmentDate'] ?? '',
                    'AppointmentDay' => $row['AppointmentDay'] ?? '',
                    'AppointmentHour' => $row['AppointmentHour'] ?? '',
                ];
            }
            return $this->response();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 전체 다운로드
    function allDown($param): void
    {
        $this->desc = 'model::allDown';
        try {
            if (!isset($param['orderIdx'], $param['target'])) {
                throw new \Exception("필수 파라미터가 없습니다.", "404");
            }
            if (!in_array($param['target'], ['ib', 'disease'])) {
                throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
            }

            $orderIdx = [];
            if ($param['orderIdx']) {
                $orderIdx = json_decode($param['orderIdx'], true);
            }
            if (count($orderIdx) < 1) {
                throw new \Exception("다운로드 대상자를 선택하지 않았습니다.", "400");
            }

            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $target = $param['target'];
            $files = [];
            $orderList = implode(',', $orderIdx);
            $dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
            array_pop($dir);
            array_pop($dir);
            $dir = implode('/', $dir);
            $filePath = "";
            if ($target === 'ib') {
                $items = [];
                $sql = "SELECT
                            mam.MemberManageIdx, mam.OrderIdx, mts.IsComplete,
                            m.Name, m.Gender, m.Birth1, m.Birth2
                        FROM phi.MemberAllocationManage mam
                        JOIN phi.MemberManage mm
                          ON mm.MemberManageIdx = mam.MemberManageIdx
                        JOIN phi.Member m
                          ON m.MemberIdx = mm.MemberIdx
                   LEFT JOIN phi.MemberTransferStatus mts
                          ON (mts.MemberManageIdx, mts.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
                       WHERE mam.OrderIdx IN ({$orderList})
                         AND mm.IsOut = b'0'";
                $stmt = $this->conn->query($sql);
                while ($row = $stmt->fetch()) {
                    $gender = $row['Gender'] === '1' ? '남' : ($row['Gender'] === '2' ? '여' : '');
                    $age = convertAging($row['Birth1'] . $row['Birth2'], date('Y-m-d'));
                    $files[$row['OrderIdx']] = [
                        'filename' => "{$row['MemberManageIdx']}_{$row['OrderIdx']}_{$param['gIdx']}",
                        'orderIdx' => $row['OrderIdx'],
                        'memberManageIdx' => $row['MemberManageIdx'],
                        'gIdx' => $param['gIdx'],
                        'downloadName' => "{$row['MemberManageIdx']}_{$row['Name']}_{$gender}_{$age}",
                    ];
                    if (!$row['IsComplete']) {
                        $items[] = [
                            'memberManageIdx' => $row['MemberManageIdx'],
                            'orderIdx' => $row['OrderIdx'],
                            'isComplete' => true,
                        ];
                    }

                }
                if (count($items) > 0) {
                    $table = "phi.MemberTransferStatus";
                    $this->bulkInsertUpdate([], $table, $items);
                }

                $filePath = "{$dir}/image/datashare/priv/ibReport/";
            } else if ($target === 'disease') {
                $sql = "SELECT
                            prm.MemberManageIdx, prm.OrderIdx, prm.ReportType, prm.`Uuid`,
                            m.Name
                        FROM phi.PhiReportManage prm
                        JOIN phi.MemberAllocationManage mam
                          ON (mam.MemberManageIdx, mam.OrderIdx) = (prm.MemberManageIdx, prm.OrderIdx)
                        JOIN phi.MemberManage mm
                          ON mm.MemberManageIdx = prm.MemberManageIdx
                        JOIN phi.Member m
                          ON m.MemberIdx = mm.MemberIdx
                       WHERE prm.OrderIdx IN ({$orderList})
                         AND mm.IsOut = b'0'
                    ORDER BY prm.NhisPreviewListIdx DESC";
                $stmt = $this->conn->query($sql);
                while ($row = $stmt->fetch()) {
                    if (isset($files[$row['OrderIdx']])) {
                        continue;
                    }
                    $files[$row['OrderIdx']] = [
                        'filename' => "{$row['MemberManageIdx']}_{$row['OrderIdx']}_{$row['ReportType']}",
                        'uuid' => $row['Uuid'],
                        'phiType' => $row['ReportType'],
                        'downloadName' => "{$row['MemberManageIdx']}_{$row['Name']}",
                    ];
                    $files[$row['OrderIdx']]['downloadName'] .= $row['ReportType'] == '1' ? "_생체나이결과지" : ($row['ReportType'] == '2' ? "_질병예측결과지" : "");
                }

                $filePath = "{$dir}/image/datashare/priv/u2medtek/";
            }

            if (count($files) === 0 || count($orderIdx) != count($files)) {
                throw new \Exception("다운 받을 수 없는 대상자들입니다. 다시 선택하십시오.", "400");
            }

            $zip = new \ZipArchive();

            $time = time();
            $zipName = "{$filePath}{$target}_{$param['gIdx']}_{$time}.zip";
            if (!$zip->open($zipName, \ZipArchive::CREATE)) {
                throw new \Exception("open error", "451");
            }

            if ($target === 'ib') {
                foreach ($files as $item) {
                    if (!file_exists("{$filePath}{$item['filename']}.pdf")) {
                        $userData = $this->getIbData($item);
                        (new Pdf())->createIbPdf($userData);
                    }
                    $zip->addFile("{$filePath}{$item['filename']}.pdf", "{$item['downloadName']}.pdf");
                }
            } else if ($target === 'disease') {
                foreach ($files as $item) {
                    if (!file_exists("{$filePath}{$item['filename']}.pdf")) {
                        $token = $this->createMedtekToken();
                        if (!$token) {
                            throw new \Exception('u2 request error', '401');
                        }
                        $reqParam = $item;
                        $reqParam['u2Token'] = $token;

                        $this->getU2Pdf($reqParam);
                    }
                    $zip->addFile("{$filePath}{$item['filename']}.pdf", "{$item['downloadName']}.pdf");
                }
            }

            $zip->close();
            $downZipName = $target . "_" . date("Y-m-d") . ".zip";

            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=$downZipName");
            readfile($zipName);
            unlink($zipName);
            exit;

        } catch (\Exception $e) {
            throw $e;
        }
    }


    // 보험상담결과 조회 - 질병예측
    function consultingResultList($param): array
    {
        $this->desc = "model::consultingResultList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['o.RegDatetime', 'm.Name', 'scm.ServiceCompanyName', 'cs.ConsultantName', 'pim.ItemName', 'im.ItemName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    if ($param['keyword'] === 'cs.PhiTransferDatetime') {
                        switch ($param['value']) {
                            case 'Y':
                                $addSql .= " AND {$param['keyword']} IS NOT NULL";
                                break;
                            case 'N':
                                $addSql .= " AND {$param['keyword']} IS NULL";
                                break;
                        }
                    } else if (in_array($param['keyword'], ['cs.StatusCode1', 'cs.StatusCode2', 'cs.StatusCode3'])) {
                        switch ($param['value']) {
                            case 'A':
                            case '계약체결':
                                $statusCodeDef = 'A';
                                break;
                            case 'B':
                            case '종결':
                                $statusCodeDef = 'B';
                                break;
                            case 'C':
                            case '결번':
                                $statusCodeDef = 'C';
                                break;
                            case 'D':
                            case '상담거절':
                                $statusCodeDef = 'D';
                                break;
                            case 'E':
                            case '무응답':
                                $statusCodeDef = 'E';
                                break;
                            case 'F':
                            case '중복':
                                $statusCodeDef = 'F';
                                break;
                            case 'G':
                            case '부재':
                                $statusCodeDef = 'G';
                                break;
                            case 'H':
                            case '병력':
                                $statusCodeDef = 'H';
                                break;
                            case 'I':
                            case '통화예약':
                                $statusCodeDef = 'I';
                                break;
                            case 'J':
                            case '상담완료':
                                $statusCodeDef = 'J';
                                break;
                            case 'K':
                            case '방문약속':
                                $statusCodeDef = 'K';
                                break;
                            case 'L':
                            case '계약대기':
                                $statusCodeDef = 'L';
                                break;
                            case 'M':
                            case '상담':
                                $statusCodeDef = 'M';
                                break;
                            case 'N':
                            case '거절':
                                $statusCodeDef = 'N';
                                break;
                            case 'O':
                            case '보완':
                                $statusCodeDef = 'O';
                                break;
                            case 'P':
                            case '인수불가':
                                $statusCodeDef = 'P';
                                break;
                            case 'Q':
                            case '신청오류':
                                $statusCodeDef = 'Q';
                                break;
                            case 'Z':
                            case '기타':
                                $statusCodeDef = 'Z';
                                break;
                            default:
                                $statusCodeDef = '';
                                break;
                        }
                        $keyword = substr($param['keyword'], 0, -1);
                        $trial = substr($param['keyword'], -1);

                        if ($trial === '1') {
                            $statusCodeDef = "{$statusCodeDef}%";
                        } else if ($trial === '2') {
                            $statusCodeDef = "_{$statusCodeDef}%";
                        } else if ($trial === '3') {
                            $statusCodeDef = "__{$statusCodeDef}";
                        }

                        $addSql .= " AND {$keyword} LIKE '{$statusCodeDef}}'";
                    } else {
                        $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                    }
                }
            }
            // 대상 전체 카운트
            $sql = "SELECT
                        o.RegDatetime, o.MemberManageIdx, o.OrderIdx,
                        m.Name, m.Phone, tm.MemberIdx AS TestMember,
                        scm.ServiceCompanyManageIdx, scm.ServiceCompanyName,
                        cs.ConsultantName, cs.StatusCode, cs.ConsultantFixDate,
                        cs.ConsultDate1, cs.ConsultDate2, cs.ConsultDate3, cs.PhiTransferDatetime,
                        pim.ItemName AS ParentItemName, im.ItemName,
                        icm.MonthlyPremium, icm.DueDay, icm.ContractDate
                    FROM phi.MemberAllocationManage mam
                    JOIN phi.ConsultingStatus cs
                      ON (cs.MemberManageIdx, cs.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
                    JOIN order.Order AS o
                      ON o.OrderIdx = mam.OrderIdx
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
                    JOIN phi.ServiceCompanyManage scm
                      ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
                    JOIN phi.MemberTransferStatus mts
                      ON (mts.MemberManageIdx, mts.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
               LEFT JOIN phi.InsuranceContractManage icm
                      ON (icm.MemberManageIdx, icm.OrderIdx) = (mam.MemberManageIdx, mam.OrderIdx)
               LEFT JOIN phi.InsuranceManage im
                      ON im.InsuranceManageIdx = icm.InsuranceManageIdx
               LEFT JOIN phi.InsuranceManage pim
                      ON pim.InsuranceManageIdx = im.ParentItemIdx
                   WHERE mm.IsOut = b'0' #탈퇴회원 제외
                     AND o.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
                     AND o.IsActive = b'1' #활성회원 선별
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql .= " ORDER BY o.RegDatetime DESC ";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $data[$item['OrderIdx']] = [
                    // 테이블 값
                    'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                    'MemberManageIdx' => $item['MemberManageIdx'],
                    'OrderIdx' => $item['OrderIdx'],
                    'Name' => $item['Name'],
                    'Phone' => $item['Phone'],
                    'TestMember' => $item['TestMember'],
                    'ServiceCompanyManageIdx' => $item['ServiceCompanyManageIdx'],
                    'ServiceCompanyName' => $item['ServiceCompanyName'],
                    'ConsultantName' => $item['ConsultantName'],
                    'StatusCode' => $item['StatusCode'],
                    'ParentItemName' => $item['ParentItemName'],
                    'ItemName' => $item['ItemName'],
                    'MonthlyPremium' => $item['MonthlyPremium'],
                    'DueDay' => $item['DueDay'],
                    'ContractDate' => $item['ContractDate'],
                    // Modal 값
                    'PhiTransferDatetime' => $item['PhiTransferDatetime'],
                    'ConsultantFixDate' => $item['ConsultantFixDate'],
                    'ConsultDate1' => $item['ConsultDate1'],
                    'ConsultDate2' => $item['ConsultDate2'],
                    'ConsultDate3' => $item['ConsultDate3'],
                ];
            }

            $this->data['data'] = $data;
            $this->conn = null;

            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험IB 할당 엑셀 업로드 (질병예측과 공통 사용)
    function uploadDbAllocation($param): array
    {
        $this->desc = 'model::uploadDbAllocation';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['gIdx'], $param[0]['dbAllocationFile'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }

            $sql = "SELECT
                        scm.ServiceCompanyManageIdx, scm.ServiceCompanyName, scm.TransferMethodCode,
                        asmh.TotalServeLimit, asmh.WeekServeLimit, asmh.RegDatetime
                      FROM phi.AllocationServeManageHistory AS asmh
                      JOIN phi.ServiceCompanyManage AS scm
                        ON scm.ServiceCompanyManageIdx = asmh.ServiceCompanyManageIdx
                     WHERE asmh.AllocationServeManageHistoryIdx IN (
                                SELECT MAX(AllocationServeManageHistoryIdx)
                                  FROM phi.AllocationServeManageHistory
                                 WHERE ProductGroupIdx = :productGroupIdx
                              GROUP BY ServiceCompanyManageIdx
                           )
                       AND scm.IsContract = b'1'
                       AND scm.TransferMethodCode IS NOT NULL
                       AND asmh.ProductGroupIdx = :productGroupIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll() ?? [];
            if (count($rows) === 0) {
                throw new \Exception('계약중인 거래처가 없거나 제공량 설정이 되어있지 않습니다.', "451");
            }

            $serviceCompanyList = [];
            $serviceCompanyData = [];
            foreach ($rows as $value) {
                $serviceCompanyData[$value['ServiceCompanyManageIdx']] = $value;
                $serviceCompanyList[$value['ServiceCompanyName']] = (int)$value['ServiceCompanyManageIdx'];

                $sql = "SELECT COUNT(*) AS TotalCnt
                          FROM phi.MemberAllocationManage AS mam
                          JOIN order.Order AS o
                            ON o.OrderIdx = mam.OrderIdx
                           AND o.ProductGroupIdx = :productGroupIdx
                         WHERE mam.ServiceCompanyManageIdx = :ServiceCompanyIdx
                           AND mam.RegDatetime >= :LatestDatetime";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
                $stmt->bindValue(':ServiceCompanyIdx', $value['ServiceCompanyManageIdx'], $this->conn::PARAM_INT);
                $stmt->bindValue(':LatestDatetime', $value['RegDatetime']);
                $stmt->execute();
                $row = $stmt->fetch();

                $serviceCompanyData[$value['ServiceCompanyManageIdx']]['TotalCnt'] = $row['TotalCnt'] ?? 0;

                $today = date('Y-m-d');
                $todayDay = date('w'); // 0:일요일 - 6:토요일
                $endDay = 6 - $todayDay;
                $startOfWeek = date('Y-m-d', strtotime($today . "-{$todayDay} day"));
                $endOfWeek = date('Y-m-d', strtotime($today . "+{$endDay} day"));

                $sql = "SELECT COUNT(*) AS WeekCnt
                          FROM phi.MemberAllocationManage AS mam
                          JOIN order.Order AS o
                            ON o.OrderIdx = mam.OrderIdx
                           AND o.ProductGroupIdx = :productGroupIdx
                         WHERE mam.ServiceCompanyManageIdx = :ServiceCompanyIdx
                           AND mam.RegDatetime >= :LatestDatetime
                           AND DATE(mam.RegDatetime) BETWEEN :StartOfWeek AND :EndOfWeek";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
                $stmt->bindValue(':ServiceCompanyIdx', $value['ServiceCompanyManageIdx'], $this->conn::PARAM_INT);
                $stmt->bindValue(':LatestDatetime', $value['RegDatetime']);
                $stmt->bindValue(':StartOfWeek', $startOfWeek);
                $stmt->bindValue(':EndOfWeek', $endOfWeek);
                $stmt->execute();
                $row = $stmt->fetch();

                $serviceCompanyData[$value['ServiceCompanyManageIdx']]['WeekCnt'] = $row['WeekCnt'] ?? 0;
            }
            $columnName = ['MemberManageIdx', 'OrderIdx', 'Name', 'Gender', 'Age', 'Address', 'ClientCustomerName', 'ServiceCompanyName'];
            $allIdxList = [];
            $idxPerServiceCompany = [];
            $insertVals = [];

            $serverFilename = $param[0]['dbAllocationFile']['tmp_name'];
            $pcFilename = $param[0]['dbAllocationFile']['name'];
            $spreadsheet = new SpreadsheetFactory();
            $result = $spreadsheet->readSheet($serverFilename, $pcFilename);
            if ($result['code'] !== 200) {
                throw new \Exception("엑셀 읽기 오류", "504");
            }

            $spreadData = $result['data'];
            if (count($spreadData) < 1) {
                throw new \Exception("양식이 입력되지 않았습니다.", "401");
            }
            foreach ($spreadData as $key => $data) {
                if (empty(array_filter($data)) || $key === 0) {
                    continue;
                }
                $rowData = array_combine($columnName, $data);
                $memberManageIdx = is_numeric($rowData['MemberManageIdx']) ? $rowData['MemberManageIdx'] : 0;
                $orderIdx = is_numeric($rowData['OrderIdx']) ? $rowData['OrderIdx'] : 0;
                if ($memberManageIdx === 0 || $orderIdx === 0) {
                    throw new \Exception('error: 주문상품ID 혹은 회원 ID값이 올바르지않습니다.', "452");
                }
                $allIdxList[] = $orderIdx;
                $serviceCompanyIdx = $serviceCompanyList[$rowData['ServiceCompanyName']] ?? 0;
                if ($serviceCompanyIdx === 0) {
                    throw new \Exception('거래처명이 올바르지 않습니다.', "452");
                }
                $insertVals[$orderIdx] = "({$memberManageIdx}, {$orderIdx}, {$param['gIdx']}, {$serviceCompanyIdx})";
                $idxPerServiceCompany[$serviceCompanyIdx][] = $orderIdx;
            }

            foreach ($idxPerServiceCompany as $key => $value) {
                $allocationCnt = count($value);
                if ($serviceCompanyData[$key]['TotalServeLimit'] < ($serviceCompanyData[$key]['TotalCnt'] + $allocationCnt)) {
                    throw new \Exception("총 제공량을 초과하게 됩니다: {$serviceCompanyData[$key]['ServiceCompanyName']}", 452);
                }
                if ($serviceCompanyData[$key]['WeekServeLimit'] < ($serviceCompanyData[$key]['WeekCnt'] + $allocationCnt)) {
                    throw new \Exception("주간 제공량을 초과하게 됩니다: {$serviceCompanyData[$key]['ServiceCompanyName']}", 452);
                }
            }

            if (count($insertVals) > 0) {
                $insertVal = implode(",", $insertVals);
                $sql = "INSERT INTO phi.`MemberAllocationManage` (
                            MemberManageIdx, OrderIdx, ProductGroupIdx, ServiceCompanyManageIdx)
                        VALUES {$insertVal}
                        ON DUPLICATE KEY UPDATE
                            ServiceCompanyManageIdx = VALUE(ServiceCompanyManageIdx) ";
                $this->conn->query($sql);
            }

            //TODO:: API전송 관련 데이터 정의 필요함 [미개발] - 얼리큐
            if ($param['gIdx'] === '2') {
                $method = "GET";
                $url = api . "/cron/allocation/send?cron=Y&isTest=Y";
                $header = [];
                $body = [
                    'cron' => "Y",
                    'isTest' => "Y",
                ];
                $result = $this->curl($method, $url, $header, $body);
                if ($result['code'] !== 200) {
                    throw new \Exception("error: allocation data send failure", 450);
                };
            }

            $this->msg = "할당 완료";

            return $this->response();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 보험IB 유저 데이터 기간별 조회
    function ibAllocationData($param): array
    {
        $this->desc = 'model::ibAllocationData';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['gIdx'], $param['serviceCompanyIdx'], $param['minDate'], $param['maxDate'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            if (
                !preg_match($this->pattern['date'], $param['minDate'])
                || !preg_match($this->pattern['date'], $param['maxDate'])
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.' , '400');
            }
            if (strtotime($param['minDate']) > strtotime($param['maxDate'])) {
                throw new \Exception('선택하신 날짜 범위가 올바르지 않습니다.' , '400');
            }

            $data = [];
            $sql = " SELECT
                          o.OrderIdx
                        , mm.MemberManageIdx
                        , m.Name, m.Gender, m.State, m.City,m.FullCity, m.Birth1, m.Birth2, m.Phone
                        , ccm.ClientCustomerName, scm.ServiceCompanyName
                      FROM phi.Member AS m
                      JOIN phi.MemberManage AS mm
                        ON mm.MemberIdx = m.MemberIdx
                      JOIN phi.ClientCustomerManage AS ccm
                        ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                      JOIN order.Order AS o
                        ON o.MemberManageIdx = mm.MemberManageIdx
                      JOIN phi.MemberAllocationManage AS mam
                        ON mam.MemberManageIdx = mm.MemberManageIdx
                       AND mam.OrderIdx = o.OrderIdx
                      JOIN phi.ServiceCompanyManage as scm
                        ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
                      WHERE o.IsActive = b'1'
                        AND mm.IsOut = b'0'
                        AND o.ProductGroupIdx = :productGroupIdx
                        AND mam.ServiceCompanyManageIdx = :serviceCompanyIdx
                        AND DATE(mam.RegDatetime) BETWEEN :minDate AND :maxDate";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':serviceCompanyIdx', $param['serviceCompanyIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':minDate', $param['minDate']);
            $stmt->bindValue(':maxDate', $param['maxDate']);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $birthDay = $row['Birth1'] . $row['Birth2'];
                $age = convertAging($birthDay, date('Y-m-d'));
                $data[] = [
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'OrderIdx' => $row['OrderIdx'],
                    'Name' => $row['Name'],
                    'Gender' => $row['Gender'] === "1" ? "남" : ($row['Gender'] === "2" ? "여" : ""),
                    'Age' => $age,
                    'Birth' => $row['Birth1'] . $row['Birth2'],
                    'Phone' => "'{$row['Phone']}",
                    'Address' => trim("{$row['State']} {$row['City']} {$row['FullCity']}"),
                    'ClientCustomerName' => $row['ClientCustomerName'] ?? '',
                    'ServiceCompanyName' => $row['ServiceCompanyName'] ?? '',
                ];
            }
            if (!count($data)) {
                throw new \Exception('조회되는 데이터가 없습니다.', '451');
            }
            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험IB 할당 유저 조회
    function findAllocateUser($param): array
    {
        $this->desc = 'model::findAllocateUser';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['gIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }

            $data = [];
            $sql = " SELECT
                          o.OrderIdx
                        , mm.MemberManageIdx
                        , m.Name, m.Gender, m.State, m.City,m.FullCity, m.Birth1, m.Birth2
                        , ccm.ClientCustomerName
                      FROM phi.Member AS m
                      JOIN phi.MemberManage AS mm
                        ON mm.MemberIdx = m.MemberIdx
                      JOIN phi.ClientCustomerManage AS ccm
                        ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                      JOIN order.Order AS o
                        ON o.MemberManageIdx = mm.MemberManageIdx
                      JOIN phi.PhiReportManage AS prm
                        ON prm.OrderIdx = o.OrderIdx
                        AND prm.MemberManageIdx = mm.MemberManageIdx
                        AND prm.ReportType = 2
                      JOIN phi.UserEventData AS ed
                        ON ed.Orderidx = o.OrderIdx
                        AND ed.MemberManageIdx = mm.MemberManageIdx
                 LEFT JOIN phi.MemberAllocationManage AS mam
                        ON mam.MemberManageIdx = mm.MemberManageIdx
                        AND mam.OrderIdx = o.OrderIdx
                     WHERE o.IsActive = b'1'
                        AND mm.IsOut = b'0'
                        AND o.ProductGroupIdx = :productGroupIdx
                        AND ed.ItemCategory = 'personal_link'
                        AND mam.OrderIdx IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $birthDay = $row['Birth1'] . $row['Birth2'];
                $age = convertAging($birthDay, date('Y-m-d'));
                $data[] = [
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'OrderIdx' => $row['OrderIdx'],
                    'Name' => $row['Name'],
                    'Gender' => $row['Gender'] === "1" ? "남" : ($row['Gender'] === "2" ? "여" : ""),
                    'Age' => $age,
                    'Address' => trim("{$row['State']} {$row['City']} {$row['FullCity']}"),
                    'ClientCustomerName' => $row['ClientCustomerName'],
                    'ServiceCompanyName' => ""
                ];
            }
            if (!count($data)) {
                throw new \Exception('조회되는 데이터가 없습니다.', '451');
            }
            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험IB 미할당 유저 조회
    function findAllocateUserforPhi($param): array
    {
        $this->desc = 'model::findAllocateUserforPhi';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['gIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            $sql = "SELECT
                        mm.MemberManageIdx, o.OrderIdx, m.Name, m.Gender, m.Birth1, m.Birth2,
                        m.State, m.City, m.FullCity, ccm.ClientCustomerName
                    FROM phi.MemberManage AS mm
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
                     AND mm.IsOut = b'0'
                     AND m.MemberIdx NOT IN (SELECT MemberIdx FROM phi.TestMember WHERE Grade = 9)
                    JOIN phi.ClientCustomerManage AS ccm
                      ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                    JOIN order.Order AS o
                      ON o.MemberManageIdx = mm.MemberManageIdx
                     AND o.ProductGroupIdx = 2
                    -- 유전자 검사 IsComplete & IsSend 완료 체크
                    JOIN phi.GeneticCompanyMemberInfo AS gcmi
                      ON gcmi.MemberManageIdx = mm.MemberManageIdx
                     AND gcmi.OrderIdx = o.OrderIdx
                     AND gcmi.IsComplete = b'1'
                     AND gcmi.IsSend = b'1'
               LEFT JOIN phi.MemberAllocationManage AS mam
                      ON mam.MemberManageIdx = mm.MemberManageIdx
                     AND mam.OrderIdx = o.OrderIdx
                   WHERE mam.MemberManageIdx IS NULL
                     AND o.ProductGroupIdx = :productGroupIdx
                     AND o.IsActive = b'1'
                     AND mm.IsOut = b'0'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll($this->conn::FETCH_ASSOC);
            foreach ($rows as $row) {
                $birthDay = $row['Birth1'] . $row['Birth2'];
                $age = convertAging($birthDay, date('Y-m-d'));
                $this->data['data'][] = [
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'OrderIdx' => $row['OrderIdx'],
                    'Name' => $row['Name'],
                    'Gender' => $row['Gender'] === "1" ? "남" : ($row['Gender'] === "2" ? "여" : ""),
                    'Age' => $age,
                    'Address' => trim("{$row['State']} {$row['City']} {$row['FullCity']}"),
                    'ClientCustomerName' => $row['ClientCustomerName'],
                    'ServiceCompanyName' => ""
                ];
            }
            if (count($rows) === 0) {
                throw new \Exception('조회 데이터가 없습니다.', '451');
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //보험사 또는 보험상품 대량등록
    function uploadInsuranceItem($param): array
    {
        $this->desc = 'uploadInsuranceItem';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param['registerType'], $param[0]['insuranceItemFile'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            $serverFilename = $param[0]['insuranceItemFile']['tmp_name'];
            $pcFilename = $param[0]['insuranceItemFile']['name'];

            $spreadsheet = new SpreadsheetFactory();
            $result = $spreadsheet->readSheet($serverFilename, $pcFilename);
            if ($result['code'] !== 200) {
                throw new \Exception('read error', 400);
            }

            $spreadData = $result['data'];
            if (count($spreadData) < 2) {
                throw new \Exception("양식이 입력되지 않았습니다.", "401");
            }
            unset($spreadData[0]);
            $items = [];
            $table = "phi.InsuranceManage";
            if ($param['registerType'] = 'insurance' && isset($param['serviceCompanyManageIdx'])) {
                foreach ($spreadData as $value) {
                    if (!$value = array_filter($value)) {
                        continue;
                    }
                    if (!$value[0]) {
                        throw new \Exception("보험사 코드 입력은 필수 입니다.", "401");
                    }
                    $items[] = [
                        'serviceCompanyManageIdx' => (int)$param['serviceCompanyManageIdx'],
                        'itemCode' => (string)$value[0],
                        'itemName' => (string)$value[1],
                    ];
                }
            } else if ($param['registerType'] = 'item') {
                foreach ($spreadData as $value) {
                    if (!$value = array_filter($value)) {
                        continue;
                    }
                    if (!$value[0]) {
                        throw new \Exception("보험사 식별코드 입력은 필수 입니다.", "401");
                    }
                    $items[] = [
                        'parentItemIdx' => (int)$value[0],
                        'itemCode' => (string)$value[1],
                        'itemName' => (string)$value[2],
                    ];
                }
            }
            $this->bulkInsertUpdate([], $table, $items);

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험사 또는 보험상품 비활성화
    function deleteInsuranceItem($param): array
    {
        $this->desc = 'model::deleteInsuranceItem';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param['insuranceManageIdx'])) {
                throw new \Exception("필수 파라미터가 없습니다.", "404");
            }
            if (!$param['insuranceManageIdx']) {
                throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
            }

            $sql = "UPDATE phi.InsuranceManage
                    SET IsUse = b'0'
                    WHERE InsuranceManageIdx = :insuranceManageIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':insuranceManageIdx', $param['insuranceManageIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험사 또는 보험상품 수정
    function updateInsuranceItem($param): array
    {
        $this->desc = 'model::updateInsuranceItem';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (
                !isset(
                    $param['parentInsuranceManageIdx'],
                    $param['parentItemCode'],
                    $param['parentItemName'],
                )
            ) {
                throw new \Exception("필수 파라미터가 없습니다.", "404");
            }
            if (
                !$param['parentInsuranceManageIdx']
                || !$param['parentItemCode']
                || !$param['parentItemName']
            ) {
                throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
            }

            if (
                !preg_match($this->pattern['code'], $param['parentItemCode'])
                || !preg_match($this->pattern['all'], $param['parentItemName'])
                || (isset($param['itemCode']) && !preg_match($this->pattern['code'], $param['itemCode']))
                || (isset($param['itemName']) && !preg_match($this->pattern['all'], $param['itemName']))
            ) {
                throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
            }
            $this->conn->beginTransaction();

            $table = 'phi.InsuranceManage';
            // 보험사 정보 수정
            $idx = [
                'insuranceManageIdx' => (int)$param['parentInsuranceManageIdx'],
            ];
            $item = [
                'itemCode' => $param['parentItemCode'],
                'itemName' => $param['parentItemName']
            ];
            $this->insertUpdate($idx, $table, $item);

            // 보험상품 정보 수정
            if (isset($param['insuranceManageIdx']) && $param['insuranceManageIdx']) {
                $idx = [
                    'insuranceManageIdx' => $param['insuranceManageIdx'],
                ];
                $item = [
                    'itemCode' => $param['itemCode'],
                    'itemName' => $param['itemName']
                ];
                $this->insertUpdate($idx, $table, $item);
            } else {
                if (
                    isset($param['itemCode'], $param['itemName'])
                    && $param['itemCode'] && $param['itemName']
                ) {
                    $item = [
                        'itemCode' => $param['itemCode'],
                        'itemName' => $param['itemName'],
                        'parentItemIdx' => $param['parentInsuranceManageIdx'],
                    ];
                    $this->insertUpdate([], $table, $item);
                }
            }

            $this->conn->commit();

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->conn = null;
            throw $e;
        }
    }

    // 보험상품 조회 insuranceItemList
    function insuranceItemList($param): array
    {
        $this->desc = "model::insuranceItemList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['scm.ServiceCompanyName', 'pi.ItemCode', 'pi.ItemName', 'i.ItemCode', 'i.ItemName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            // 대상 전체 카운트
            $sql = "SELECT
                        scm.ServiceCompanyName, pi.InsuranceManageIdx AS ParentInsuranceManageIdx,
                        pi.ItemCode AS ParentItemCode, pi.ItemName AS ParentItemName,
                        i.InsuranceManageIdx, i.ItemCode, i.ItemName
                    FROM phi.InsuranceManage pi
                    JOIN phi.ServiceCompanyManage scm
                      ON scm.ServiceCompanyManageIdx = pi.ServiceCompanyManageIdx
               LEFT JOIN phi.InsuranceManage i
                      ON i.ParentItemIdx = pi.InsuranceManageIdx
                     AND i.IsUse = b'1'
                     AND i.ParentItemIdx IS NOT NULL
                   WHERE scm.IsContract = b'1'
                     AND pi.IsUse = b'1'
                     AND pi.ParentItemIdx IS NULL
                     {$addSql}";

            $stmt = $this->conn->query($sql);
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                $data[] = [
                    'ServiceCompanyName' => $item['ServiceCompanyName'],
                    'ParentInsuranceManageIdx' => $item['ParentInsuranceManageIdx'],
                    'ParentItemCode' => $item['ParentItemCode'],
                    'ParentItemName' => $item['ParentItemName'],
                    'InsuranceManageIdx' => $item['InsuranceManageIdx'],
                    'ItemCode' => $item['ItemCode'],
                    'ItemName' => $item['ItemName'],
                ];
            }

            $sql = "SELECT ServiceCompanyManageIdx AS `value`, ServiceCompanyName AS `text`
                    FROM phi.ServiceCompanyManage
                    WHERE IsContract = b'1'";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];

            $this->data['data'] = $data;
            $this->data['select::serviceCompany'] = $row;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험 IB 리스트 (질병예측 전용)
    function insureIbListforPhi($param): array
    {
        $this->desc = 'model::insureIbListforPhi';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['m.Name', 'm.Phone', 'prm.CalcDate', 'm.State', 'm.City', 'ccm.ClientCustomerName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else if ($param['keyword'] === 'mts.IsComplete') {
                    if ($param['value'] === '전송') {
                        $addSql .= " AND {$param['keyword']} = b'1'";
                    } else {
                        $addSql .= " AND ( {$param['keyword']} = b'0' OR {$param['keyword']} IS NULL)";
                    }
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                if ($param['column'] === 'Address') {
                    $orderSql .= " m.State {$param['sort']}, m.City {$param['sort']}, m.FullCity {$param['sort']} ";
                } else {
                    $orderSql .= " {$param['column']} {$param['sort']} ";
                }
            } else {
                $orderSql .= ' prm.CalcDate DESC ';
            }

            $sql = "  SELECT
                          prm.CalcDate
                        , o.OrderIdx
                        , mm.MemberManageIdx
                        , m.Name, m.State, m.City
                        , mam.RegDatetime
                        , ccm.ClientCustomerName
                        , scm.TransferMethodCode
                        , scm.ServiceCompanyName, scm.ServiceCompanyManageIdx
                        , mts.RegDatetime AS IsPost
                        , prm.uuid
                        FROM order.Order AS o
                        -- MemberIdx, MemberManageIdx 가져오기
                        JOIN phi.MemberManage AS mm
                          ON mm.MemberManageIdx = o.MemberManageIdx
                        JOIN phi.Member AS m
                          ON m.MemberIdx = mm.MemberIdx
                         AND m.MemberIdx NOT IN (SELECT MemberIdx FROM phi.TestMember WHERE Grade = 9)
                        JOIN phi.ClientCustomerManage as ccm
                          ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                        -- 유전자 검사 IsComplete & IsSend 완료 체크
                        JOIN phi.GeneticCompanyMemberInfo AS gcmi
                          ON gcmi.MemberManageIdx = o.MemberManageIdx
                         AND gcmi.OrderIdx = o.OrderIdx
                         AND gcmi.IsComplete = b'1'
                         AND gcmi.IsSend = b'1'
                        JOIN phi.PhiReportManage AS prm
                          ON prm.MemberManageIdx = mm.MemberManageIdx
                         AND prm.OrderIdx = o.OrderIdx
                   LEFT JOIN phi.MemberAllocationManage AS mam
                          ON mam.MemberManageIdx = mm.MemberManageIdx
                         AND mam.OrderIdx = o.OrderIdx
                   LEFT JOIN phi.MemberTransferStatus AS mts
                          ON mts.MemberManageIdx = mam.MemberManageIdx
                         AND mts.OrderIdx = mam.OrderIdx
                   LEFT JOIN phi.ServiceCompanyManage AS scm
                          ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
                       WHERE o.ProductGroupIdx = :productGroupIdx
                         AND o.IsActive = b'1'
                         AND mm.IsOut = b'0'
                         {$addSql}
                    GROUP BY o.OrderIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = 0;
            $allocationCount = 0;
            $notAllocationCount = 0;
            while($row = $stmt->fetch()) {
                $total++;
                if($row['RegDatetime']) {
                    $allocationCount ++;
                } else {
                    $notAllocationCount ++;
                }
            }
            $this->data['text::count'] = [
                'allocationCount' => $allocationCount,
                'notAllocationCount' => $notAllocationCount,
            ];
            $this->setPagination($total, $param);

            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $this->data['data']["idx{$row['OrderIdx']}"] = [
                    'CalcDate' => $row['CalcDate'],
                    'Name' => $row['Name'],
                    'State' => $row['State'] ?? '',
                    'City' => $row['City'] ?? '',
                    'RegDatetime' => $row['RegDatetime'] ? substr($row['RegDatetime'], 0, 10) : '',
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'OrderIdx' => $row['OrderIdx'],
                    'ClientCustomerName' => $row['ClientCustomerName'],
                    'ServiceCompanyName' => $row['ServiceCompanyName'] ?? '',
                    'TransferMethodCode' => $row['TransferMethodCode'] ?? '',
                    'IsPost' => $row['IsPost'] ? substr($row['IsPost'], 0, 10) : '',
                    'uuid' => $row['uuid'] ?? '',
                ];
            }
            //@TODO 노출되어야하는 ServiceCompany에 대한 정의가 없는 상황, 따라 전체 ServiceCompany 노출하도록 현재 설정
            $sql = "SELECT ServiceCompanyManageIdx, ServiceCompanyName
                      FROM phi.ServiceCompanyManage AS scm
                     #WHERE IsContract = b'1'";
            $stmt = $this->conn->query($sql);
            while ($row = $stmt->fetch()) {
                $this->data['select::serviceCompany'][$row['ServiceCompanyManageIdx']] = [
                    'value' => $row['ServiceCompanyManageIdx'],
                    'text' => $row['ServiceCompanyName'],
                ];
            }

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 보험 IB 리스트
    function insureIbList($param): array
    {
        $this->desc = 'model::insureIbList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['m.Name', 'm.Phone', 'prm.CalcDate', 'm.State', 'm.City', 'ccm.ClientCustomerName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else if ($param['keyword'] === 'mts.IsComplete') {
                    if ($param['value'] === '전송') {
                        $addSql .= " AND {$param['keyword']} = b'1'";
                    } else {
                        $addSql .= " AND ({$param['keyword']} = b'0' OR {$param['keyword']} IS NULL)";
                    }
                } else if ($param['keyword'] === 'cs.ConsultantType') {
                    if ($param['value'] === '설명듣기') {
                        $addSql .= " AND {$param['keyword']} = 'R'";
                    } else if ($param['value'] === '나중에') {
                        $addSql .= " AND {$param['keyword']} = 'L'";
                    } else if ($param['value'] === '미응답') {
                        $addSql .= " AND {$param['keyword']} = 'N'";
                    }
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                if ($param['column'] === 'Address') {
                    $orderSql .= " m.State {$param['sort']}, m.City {$param['sort']}, m.FullCity {$param['sort']} ";
                } else {
                    $orderSql .= " {$param['column']} {$param['sort']} ";
                }
            } else {
                $orderSql .= ' prm.CalcDate DESC ';
            }
            $sql = " SELECT
                          prm.CalcDate
                        , o.OrderIdx
                        , cs.ConsultantType
                        , mm.MemberManageIdx
                        , m.Name, m.State, m.City
                        , mam.RegDatetime
                        , ccm.ClientCustomerName
                        , scm.TransferMethodCode
                        , scm.ServiceCompanyName, scm.ServiceCompanyManageIdx
                        , mts.RegDatetime AS IsPost
                        , prm.uuid
                        , sm.LatestDatetime
                        , prm.Data
                      FROM phi.Member AS m
                      JOIN phi.MemberManage AS mm
                        ON mm.MemberIdx = m.MemberIdx
                      JOIN phi.ClientCustomerManage AS ccm
                        ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                      JOIN order.Order AS o
                        ON o.MemberManageIdx = mm.MemberManageIdx
                      JOIN phi.PhiReportManage AS prm
                        ON prm.OrderIdx = o.OrderIdx
                       AND prm.MemberManageIdx = mm.MemberManageIdx
                       AND prm.ReportType = 2
                 LEFT JOIN phi.ConsultingStatus AS cs
                        ON cs.MemberManageIdx = mm.MemberManageIdx
                       AND cs.OrderIdx = o.OrderIdx
                 LEFT JOIN phi.MemberAllocationManage AS mam
                        ON mam.MemberManageIdx = mm.MemberManageIdx
                       AND mam.OrderIdx = o.OrderIdx
                 LEFT JOIN phi.MemberTransferStatus AS mts
                        ON mts.MemberManageIdx = mam.MemberManageIdx
                       AND mts.OrderIdx = mam.OrderIdx
                 LEFT JOIN phi.ServiceCompanyManage AS scm
                        ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
                 LEFT JOIN sms.SendManage sm
                        ON sm.MemberManageIdx = mm.MemberManageIdx
                       AND sm.OrderIdx = o.OrderIdx
                       AND sm.ProcessStep = 34
                     WHERE o.IsActive = b'1'
                       AND mm.IsOut = b'0'
                       AND o.ProductGroupIdx = :productGroupIdx
                       AND cs.ConsultantType IS NOT NULL
                       AND (
                           !(sm.SendCount >= 2 AND DATE(sm.LatestDatetime) <= :targetDate)
                           OR sm.SendCount IS NULL
                       )
                       {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':targetDate', date('Y-m-d', strtotime('-10 days')));
            $stmt->execute();
            //할당 인원, 미할당 인원
            $allocationCount = 0;
            $notAllocationCount = 0;
            $total = 0;
            while($row = $stmt->fetch()) {
                $total++;
                if($row['RegDatetime']) {
                    $allocationCount ++;
                } else {
                    $notAllocationCount ++;
                }
            }
            $this->data['text::count'] = [
                'allocationCount' => $allocationCount,
                'notAllocationCount' => $notAllocationCount,
            ];
            $this->setPagination($total, $param);

            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':targetDate', date('Y-m-d', strtotime('-10 days')));
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $this->data['data']["idx{$row['OrderIdx']}"] = [
                    'CalcDate' => $row['CalcDate'],
                    'Name' => $row['Name'],
                    'State' => $row['State'] ?? '',
                    'City' => $row['City'] ?? '',
                    'RegDatetime' => $row['RegDatetime'] ? substr($row['RegDatetime'], 0, 10) : '',
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'OrderIdx' => $row['OrderIdx'],
                    'ClientCustomerName' => $row['ClientCustomerName'],
                    'ServiceCompanyName' => $row['ServiceCompanyName'] ?? '',
                    'TransferMethodCode' => $row['TransferMethodCode'] ?? '',
                    'ConsultantType' => $row['ConsultantType'] ?? '',
                    'IsPost' => $row['IsPost'] ? substr($row['IsPost'], 0, 10) : '',
                    'uuid' => $row['uuid'] ?? '',
                    'CWCnt' => 0,
                    'DHCnt' => 0,
                ];

                $phiData = json_decode($row['Data'], true);
                foreach ($phiData as $val) {
                    $stat = $this->bioMarkerGradeCovert($val['rrisk']);
                    if ($stat === '양호') {
                        continue;
                    }
                    if (in_array($stat, ['주의', '경고'])) {
                        $this->data['data']["idx{$row['OrderIdx']}"]['CWCnt']++;
                    }
                    if (in_array($stat, ['위험', '고위험'])) {
                        $this->data['data']["idx{$row['OrderIdx']}"]['DHCnt']++;
                    }
                }
            }
            $sql = "SELECT ServiceCompanyManageIdx, ServiceCompanyName
                      FROM phi.ServiceCompanyManage AS scm
                     WHERE IsContract = b'1'";
            $stmt = $this->conn->query($sql);
            while ($row = $stmt->fetch()) {
                $this->data['select::serviceCompany'][$row['ServiceCompanyManageIdx']] = [
                    'value' => $row['ServiceCompanyManageIdx'],
                    'text' => $row['ServiceCompanyName'],
                ];
            }

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 요약 검사 결과
    function summaryList($param): array
    {
        $this->desc = 'model::summaryList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['m.Name', 'm.Phone', 'ed.RegDatetime', 'prm.CalcDate', 'cs.AppointmentDate'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else if ($param['keyword'] === 'IsAccess') {
                    if ($param['value'] === 'Y') {
                        $addSql .= " AND cs.ConsultantType IS NOT NULL ";
                    } else if ($param['value'] === 'N') {
                        $addSql .= " AND cs.ConsultantType IS NULL ";
                    }
                } else if ($param['keyword'] === 'cs.ConsultantType') {
                    if ($param['value'] === '설명듣기') {
                        $addSql .= " AND {$param['keyword']} = 'R'";
                    } else if ($param['value'] === '나중에') {
                        $addSql .= " AND {$param['keyword']} = 'L'";
                    } else if ($param['value'] === '미응답') {
                        $addSql .= " AND {$param['keyword']} = 'N'";
                    } else if ($param['value'] === '미접속') {
                        $addSql .= " AND {$param['keyword']} IS NULL";
                    }
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            $sql = " SELECT
                          m.Name, m.Phone
                        , prm.CalcDate
                        , mm.MemberManageIdx
                        , ccm.ClientCustomerName
                        , o.OrderIdx
                        , p.ProductName, p.ProductIdx
                        , cs.ConsultantType, cs.AppointmentHour, cs.AppointmentDate
                        , ed.RegDatetime AS EventDate
                      FROM phi.Member AS m
                      JOIN phi.MemberManage AS mm
                        ON mm.MemberIdx = m.MemberIdx
                      JOIN phi.ClientCustomerManage AS ccm
                        ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                        AND ccm.Depth =2
                      JOIN phi.ProductGroupManage AS pgm
                        ON pgm.ProductGroupIdx = :productGroupIdx
                      JOIN phi.Product AS p
                        ON p.ProductIdx = pgm.ProductIdx
                      JOIN order.Order AS o
                        ON o.MemberManageIdx = mm.MemberManageIdx
                      JOIN phi.PhiReportManage AS prm
                        ON prm.OrderIdx = o.OrderIdx
                       AND prm.MemberManageIdx = o.MemberManageIdx
                       AND prm.ReportType = 2  #질환예측
                 LEFT JOIN phi.ConsultingStatus AS cs
                        ON cs.MemberManageIdx = mm.MemberManageIdx
                       AND cs.OrderIdx = o.OrderIdx
                 LEFT JOIN phi.UserEventData AS ed
                        ON ed.OrderIdx = o.OrderIdx
                       AND ed.MemberManageIdx = mm.MemberManageIdx
                       AND ed.ItemCategory = 'personal_link'
                     WHERE o.ProductGroupIdx = :productGroupIdx
                       AND p.ProductIdx = 4
                       AND o.IsActive = b'1'
                       AND mm.IsOut = b'0'
                       {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = $stmt->fetchAll();
            $this->setPagination(count($total), $param);

            $sql .= " ORDER BY prm.CalcDate DESC ";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $this->data['data'][$row['OrderIdx']] = [
                    'CalcDate' => $row['CalcDate'],
                    'Name' => $row['Name'],
                    'Phone' => $row['Phone'],
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'ClientCustomerName' => $row['ClientCustomerName'],
                    'ConsultantType' => $row['ConsultantType'] ?? '',
                    'AppointmentHour' => $row['AppointmentHour'] ?? '',
                    'AppointmentDate' => $row['AppointmentDate'] ?? '',
                    'EventDate' => $row['EventDate'] ? substr($row['EventDate'], 0, 10) : '',
                ];
            }

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 알림톡 전송(복수건 전송)
    function sender(array $senderData): array
    {
        $this->desc = 'model::sender';
        try {
            if (count($senderData) === 0) {
                throw new \Exception("BizM 전송할 데이터가 없습니다.", "404");
            }

            $resultData = [
                'success' => 0,
                'failure' => 0
            ];

            $logParams = [];
            $sendData = [];

            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $url = "{$this->apiBizMUrl}/v2/sender/send";

            $header = [
                'Content-type: application/json',
                'userId: ' . $this->apiBizMId
            ];

            // request body, request log 만들기
            foreach ($senderData as $row) {
                if (isset($row['shortUrl'])) {
                    $row['messageSms'] .= $row['shortUrl'];
                }
                if (!isDev) {
                    if ($row['templateId'] === 'geno04') {
                        $this->apiBizMKey = $this->apiBizMBioAgeKey;
                    } else if (strpos($row['templateId'], 'earlyq') !== false) {
                        $this->apiBizMKey = $this->apiBizMEarlyQKey;
                    } else if (strpos($row['templateId'], 'coupon') !== false) {
                        $this->apiBizMKey = $this->apiBizMCouponKey;
                    } else {
                        $this->apiBizMKey = $this->apiBizMPhiKey;
                    }
                }

                $params = [
                    'memberManageIdx' => ($row['memberManageIdx']) ?? "",
                    'orderIdx' => ($row['orderIdx']) ?? "",
                    'profile' => $this->apiBizMKey,
                    'templateId' => $row['templateId'],
                    'messageType' => $row['messageType'],
                    'phone' => $row['phone'],
                    'message' => $row['message'],
                    'title' => $row['title'],
                    'reserveDatetime' => ($row['reserveDatetime']) ?? "00000000000000",
                    'smsKind' => $row['smsKind'],
                    'smsSender' => $row['smsSender'],
                    'messageSms' => $row['messageSms'],
                    'smsLmsTit' => $row['smsLmsTit'] ?? "",
                ];
                if (isset($row['shortUrl'])) {
                    $params['button1'] = [
                        'name' => $row['buttonName'],
                        'type' => "WL",
                        'url_mobile' => $row['shortUrl'],
                        'url_pc' => $row['shortUrl'],
                        'target' => "out"
                    ];
                }
                if (isset($row['memberManageIdx'], $row['orderIdx'])) {
                    $logParams['request'][] = $params;
                }

                $body = [
                    'message_type' => $params['messageType'],
                    'phn' => $params['phone'],
                    'profile' => $this->apiBizMKey,
                    'reserveDt' => $params['reserveDatetime'],
                    'msg' => $params['message'],
                    'tmplId' => $params['templateId'],
                    'smsKind' => $params['smsKind'], //대체문자 사용여부
                    'msgSms' => $params['messageSms'], //대체문자 MSG
                    'smsSender' => $params['smsSender'] //대체문자 발신번호
                ];
                if (isset($params['title'])) {
                    $body['title'] = $params['title'];
                }
                if (isset($params['button1'])) {
                    $body['button1'] = $params['button1'];
                }
                if (isset($params['smsLmsTit'])) {
                    $body['smsLmsTit'] = $params['smsLmsTit']; //대체문자 제목
                }

                // BizM 통신부
                $result = $this->curl('POST', $url, $header, json_encode([$body], true));
                $response = json_decode($result['response'], true)[0];
                if (isset($row['memberManageIdx'], $row['orderIdx'])) {
                    $logParams['response'][] = [
                        'memberManageIdx' => $row['memberManageIdx'],
                        'orderIdx' => $row['orderIdx'],
                        'code' => $response['code'],
                        'phone' => $response['data']['phn'],
                        'type' => $response['data']['type'],
                        'messageId' => $response['data']['msgid'],
                        'message' => $response['message'],
                        'originMessage' => $response['originMessage']
                    ];
                }

                if ($response['code'] == 'success') {
                    if (isset($row['memberManageIdx'], $row['orderIdx'])) {
                        $sendData['manage'][] = [
                            'memberManageIdx' => $row['memberManageIdx'],
                            'orderIdx' => $row['orderIdx'],
                            'processStep' => (int)$row['processType'],
                        ];

                        //ResultDate 함수 추가
                        $sendDate = ($params['reserveDatetime'] == '00000000000000') ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($params['reserveDatetime']));
                        $sendData['result'][] = [
                            'memberManageIdx' => $row['memberManageIdx'],
                            'orderIdx' => $row['orderIdx'],
                            'processStep' => (int)$row['processType'],
                            'msgId' => $response['data']['msgid'],
                            'sendDate' => $sendDate,
                        ];
                    }

                    $resultData['success']++;
                } else {
                    $resultData['failure']++;
                }
            }
            if ($logParams) {
                $this->insertLog($logParams);
            }
            if ($sendData && $resultData['success'] > 0) {
                $this->sendDataInsertUpdate($sendData);
            }

            $this->data = $resultData;

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    private function sendDataInsertUpdate($params): void
    {
        try {
            $sendManage = $params['manage'];
            $sendResult = $params['result'];

            // SendManage 테이블 입력부
            $placeHolder = "(" . implode(',', array_fill(0, count($sendManage[0]), "?")) . ", 1)";
            $placeHolders = implode(',', array_fill(0, count($sendManage), $placeHolder));

            $sql = "INSERT INTO sms.SendManage (
                        MemberManageIdx, OrderIdx, ProcessStep, SendCount)
                    VALUES {$placeHolders}
                    ON DUPLICATE KEY UPDATE
                        SendCount = SendCount + 1,
                        LatestDatetime = NOW()";
            $stmt = $this->conn->prepare($sql);
            $flat = call_user_func_array('array_merge', array_map('array_values', $sendManage));
            $stmt->execute($flat);

            // SendResult 테이블 입력부
            $placeHolder = "(" . implode(',', array_fill(0, count($sendResult[0]), "?")) . ", 0)";
            $placeHolders = implode(',', array_fill(0, count($sendResult), $placeHolder));

            $sql = "INSERT INTO sms.SendResult (
                        MemberManageIdx, OrderIdx, ProcessStep, MsgId, SendDate, IsSend)
                    VALUES {$placeHolders}";
            $stmt = $this->conn->prepare($sql);
            $flat = call_user_func_array('array_merge', array_map('array_values', $sendResult));
            $stmt->execute($flat);

            return;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function insertLog($params): void
    {
        try {
            $requestLog = [];
            $responseLog = $params['response'];
            foreach($params['request'] as $row){
                if (isset($row['button1'])) {
                    unset($row['button1']);
                }
                $requestLog[]  = $row;
            }

            // request log 입력부
            $placeHolder = "(" . implode(',', array_fill(0, count($requestLog[0]), "?")) . ")";
            $placeHolders = implode(',', array_fill(0, count($requestLog), $placeHolder));

            $sql = "INSERT INTO log.SendSmsRequestLog (
                        MemberManageIdx, OrderIdx, Profile, TemplateId, MessageType, Phone, Message, Title,
                        ReserveDatetime, SmsKind, SmsSender, MessageSms, SmsLmsTit)
                    VALUE {$placeHolders}";
            $stmt = $this->conn->prepare($sql);
            $flat = call_user_func_array('array_merge', array_map('array_values', $requestLog));
            $stmt->execute($flat);

            // response log 입력부
            $placeHolder = "(" . implode(',', array_fill(0, count($responseLog[0]), "?")) . ")";
            $placeHolders = implode(',', array_fill(0, count($responseLog), $placeHolder));

            $sql = "INSERT INTO log.SendSmsResponseLog (
                        MemberManageIdx, OrderIdx, Code, Phone, Type, MessageId, ResponseMessageCode, OriginMessage)
                    VALUE {$placeHolders}";
            $stmt = $this->conn->prepare($sql);
            $flat = call_user_func_array('array_merge', array_map('array_values', $responseLog));
            $stmt->execute($flat);

            return;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 알림톡 일괄전송 sendSms
    function sendSms($param): array
    {
        $this->desc = 'model::sendSms';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param['gIdx'], $param['idxList'], $param['bizMTemplate'])) {
                throw new \Exception("필수 파라미터가 없습니다.", "404");
            }
            if (!preg_match('/^[0-9\,]+$/', $param['idxList'])) {
                throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
            }

            $idxList = explode(',', $param['idxList']);

            $sql = "SELECT
                        *
                    FROM sms.BizMTemplateManage
                   WHERE ProcessStep = :bizMTemplate
                     AND IsUse = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':bizMTemplate', $param['bizMTemplate'], $this->conn::PARAM_INT);
            $stmt->execute();
            $bizMTemplateList = [];
            while ($row = $stmt->fetch()) {
                $subDivisionType = $row['SubDivisionType'] ?: 0;
                $bizMTemplateList[$subDivisionType] = $row;
            }
            if (!$bizMTemplateList) {
                throw new \Exception("사용 중인 BizM 템플릿이 없습니다.", "404");
            }

            switch ($param['bizMTemplate']) {
                case '10' :
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone,
                                sul.ShortUrl
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ShortUrlList sul
                              ON sul.MemberManageIdx = sul.MemberManageIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'";
                    break;
                case '21' :
                case '22' :
                case '31':
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'";
                    break;
                case '23' :
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone,
                                ccm.ClientCustomerName, ccm.ResponseType
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ClientCustomerManage ccm
                              ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                            JOIN phi.GeneticCompanyMemberInfo gcmi
                              ON (gcmi.MemberManageIdx, gcmi.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'
                             AND gcmi.IsSend = b'1'";
                    break;
                case '24' :
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone,
                                cs.AppointmentDay, cs.AppointmentHour, cs.ConsultantName, cs.ConsultantIdx,
                                mam.ServiceCompanyManageIdx, scm.TransferMethodCode
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ConsultingStatus cs
                              ON (cs.MemberManageIdx, cs.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                            JOIN phi.MemberAllocationManage mam
                              ON (mam.MemberManageIdx, mam.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                            JOIN phi.ServiceCompanyManage scm
                              ON scm.ServiceCompanyManageIdx = mam.ServiceCompanyManageIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'";
                    break;
                case '32':
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone, cm.QRurl
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ClientCustomerManage AS cm
							  ON cm.ClientCustomerManageIdx =  mm.ClientCustomerManageIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND mm.IsOut = b'0'";
                    break;
                case '33':
                case '34':
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone, cm.ClientCustomerName
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ClientCustomerManage AS cm
							  ON cm.ClientCustomerManageIdx =  mm.ClientCustomerManageIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'";
                    break;
                case '35':
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone, cs.AppointmentDate,cs.AppointmentHour
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.ConsultingStatus cs
                              ON (cs.MemberManageIdx, cs.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ClientCustomerManage AS cm
							  ON cm.ClientCustomerManageIdx =  mm.ClientCustomerManageIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'
                             AND cs.AppointmentDate IS NOT NULL
                             ";
                    break;
                case '36':
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ClientCustomerManage AS cm
							  ON cm.ClientCustomerManageIdx =  mm.ClientCustomerManageIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'";
                    break;
                case '37':
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'";
                    break;
                case '38':
                    $sql = "SELECT
                                o.MemberManageIdx, o.OrderIdx, m.Name, m.Phone, cm.ClientCustomerName
                            FROM order.Order o
                            JOIN phi.MemberManage mm
                              ON mm.MemberManageIdx = o.MemberManageIdx
                            JOIN phi.Member m
                              ON m.MemberIdx = mm.MemberIdx
                            JOIN phi.ClientCustomerManage AS cm
							  ON cm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                           WHERE o.OrderIdx IN ({$param['idxList']})
                             AND o.ProductGroupIdx = :productGroupIdx
                             AND o.IsActive = b'1'
                             AND mm.IsOut = b'0'";
                    break;
                default :
                    throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $sendData = [];
            $failureIdx = $idxList;
            while ($row = $stmt->fetch()) {
                $messageType = "AI";
                $devPhone = "01041033708";
                $smsKind = "L";
                $smsSender = "0316286176";
                $templateId = '';
                $message = '';
                $smsLmsTit = '';
                switch ($param['bizMTemplate']) {
                    case '10':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $smsLmsTit = "결과안내";
                        $shortUrl = $row['ShortUrl'];
                        $btnName = "결과확인 하기";
                        break;
                    case '21':
                    case '31':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $smsLmsTit = "접수알림";
                        break;
                    case '22':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $smsLmsTit = "질환예측";
                        break;
                    case '23':
                        $templateId = $bizMTemplateList[$row['ResponseType']]['TemplateCode'];
                        $message = $bizMTemplateList[$row['ResponseType']]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $message = str_replace('#{병원명}', $row['ClientCustomerName'], $message);
                        $smsLmsTit = "유전자 결과지 알림";
                        break;
                    case '24':
                        if (
                            // 알림톡 미대상자
                            // 테스트 거래처일 경우 (serviceCompanyManageIdx = 4)
                            // api전송(transferMethodCode = 1)일 때, 상담원 지정이 되지 않았을 경우
                            $row['ServiceCompanyManageIdx'] === '4'
                            || ($row['TransferMethodCode'] === '1' && !$row['ConsultantIdx'])
                        ) {
                            continue 2;
                        }
                        $templateId = $bizMTemplateList[$row['ResponseType']]['TemplateCode'];
                        $message = $bizMTemplateList[$row['ResponseType']]['Message'];
                        $consultTimeArr = [
                            '10' => "오전 10시",
                            '11' => "오전 11시",
                            '12' => "오후 12시",
                            '13' => "오후 1시",
                            '14' => "오후 2시",
                            '15' => "오후 3시",
                            '16' => "오후 4시",
                            '17' => "오후 5시",
                            '18' => "오후 6시 이후",
                        ];
                        $consultWeekArr = [
                            '1' => "평일",
                            '6' => "주말",
                            '8' => "항상가능"
                        ];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $message = str_replace('#{요일}', $consultWeekArr[$row['AppointmentDay']], $message);
                        $message = str_replace('#{시간}', $consultTimeArr[$row['AppointmentHour']], $message);
                        $message = str_replace('#{이름}', $row['ConsultantName'], $message);
                        $smsLmsTit = "상담알림";
                        break;
                    case '32':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $smsLmsTit = "";
                        $shortUrl = str_replace('.qr', '', $row['QRurl']);
                        $btnName = "이어서 신청 하기";
                        break;
                    case '33':
                    case '34':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $message = str_replace('#{약국}', $row['ClientCustomerName'], $message);

                        $urlParam = "{$row['MemberManageIdx']}/{$row['OrderIdx']}";
                        $encryptParam = $this->Encrypt($urlParam);
                        $url = "{$this->personalLinkUrl}&reg={$encryptParam}";
                        $result = (new NaverShortUrl())->getResult(['url' => $url]);
                        if ($result['code'] !== 200) {
                            throw new \Exception("URL 생성에 실패하였습니다.", "400");
                        }
                        $response = json_decode($result['response'], true);
                        $smsLmsTit = "결과안내";
                        $shortUrl = $response['result']['url'];
                        $btnName = "요약 결과 확인하기";
                        break;
                    case '35':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];

                        $consultTimeArr = [
                            '10' => "오전 10시",
                            '11' => "오전 11시",
                            '12' => "오후 12시",
                            '13' => "오후 1시",
                            '14' => "오후 2시",
                            '15' => "오후 3시",
                            '16' => "오후 4시",
                            '17' => "오후 5시",
                            '18' => "오후 6시 이후",
                        ];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $message = str_replace('#{날짜}', date('Y년 m월 d일', strtotime($row['AppointmentDate'])), $message);
                        $message = str_replace('#{시간}', $consultTimeArr[$row['AppointmentHour']], $message);
                        break;
                    case '36':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $smsLmsTit = "상담알림";
                        break;
                    case '37':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $urlParam = "{$row['MemberManageIdx']}/{$row['OrderIdx']}";
                        $encryptParam = $this->Encrypt($urlParam);
                        $url = "{$this->personalLinkUrl}&reg={$encryptParam}";
                        $result = (new NaverShortUrl())->getResult(['url' => $url]);
                        if ($result['code'] !== 200) {
                            throw new \Exception("URL 생성에 실패하였습니다.", "400");
                        }
                        $response = json_decode($result['response'], true);
                        $smsLmsTit = "결과안내";
                        $shortUrl = $response['result']['url'];
                        $btnName = "선택하러 가기";
                        break;
                    case '38':
                        $templateId = $bizMTemplateList[0]['TemplateCode'];
                        $message = $bizMTemplateList[0]['Message'];
                        $message = str_replace('#{NAME}', $row['Name'], $message);
                        $message = str_replace('#{약국}', $row['ClientCustomerName'], $message);
                        $urlParam = "{$row['MemberManageIdx']}/{$row['OrderIdx']}";
                        $encryptParam = $this->Encrypt($urlParam);
                        $url = "{$this->phiReportUrl}&reg={$encryptParam}";
                        $result = (new NaverShortUrl())->getResult(['url' => $url]);
                        if ($result['code'] !== 200) {
                            throw new \Exception("URL 생성에 실패하였습니다.", "400");
                        }
                        $response = json_decode($result['response'], true);
                        $smsLmsTit = "결과안내";
                        $shortUrl = $response['result']['url'];
                        $btnName = "결과 확인 하기";
                        break;
                    default :
                        throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
                }

                $requestParam = [
                    'memberManageIdx' => $row['MemberManageIdx'],
                    'orderIdx' => $row['OrderIdx'],
                    'templateId' => $templateId,
                    'messageType' => $messageType,
                    'phone' => (isDev) ? $devPhone : $row['Phone'],
                    'message' => $message,
                    'title' => '',
                    'reserveDatetime' => '00000000000000',
                    'smsKind' => $smsKind,
                    'smsSender' => $smsSender,
                    'processType' => $param['bizMTemplate'],
                    'smsLmsTit' => $smsLmsTit,
                    'messageSms' => $message,
                ];
                if (isset($shortUrl, $btnName)) {
                    $requestParam['shortUrl'] = $shortUrl;
                    $requestParam['buttonName'] = $btnName;
                }

                $key = array_search($row['OrderIdx'], $failureIdx);
                if ($key) {
                    unset($failureIdx[$key]);
                }
                $sendData[] = $requestParam;
            }

            if (count($sendData) === 0) {
                throw new \Exception("선택하신 대상자들은 해당 알림톡 대상자들이 아닙니다.", "400");
            }

            $response = $this->sender($sendData);
            $this->data = $response['data'];

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    public function Encrypt($str, $secret_key = 'bJ2yaNd2U#IoqkgaHCg6%yoPYRHVpdMP', $secret_iv = 'eH3iK6jyQa7XWatdWd#hnvCEgwt8MAYF')
    {
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 32);
        return @str_replace("=", "", base64_encode(
                openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
        );
    }

    // 맞춤 영양 리스트
    function supplementList($param): array
    {
        $this->desc = 'model::supplementList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['m.Name', 'm.Phone', 'ed.RegDatetime'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else if (strpos($param['keyword'], 'ed.EventItemManageIdx_') !== false) {
                    $_k = explode('_', $param['keyword']);
                    $addSql .= " AND {$_k[0]} = {$_k[1]} AND ed.DataContent LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            $sql = " SELECT o.OrderIdx,
                           m.Name, m.Phone,
                           mm.MemberManageIdx,
                           ed.RegDatetime
                      FROM phi.Member AS m
                      JOIN phi.MemberManage AS mm
                        ON mm.MemberIdx = m.MemberIdx
                      JOIN order.Order AS o
                        ON o.MemberManageIdx = mm.MemberManageIdx
                      JOIN phi.UserEventData AS ed
                        ON ed.MemberManageIdx = mm.MemberManageIdx
                       AND ed.OrderIdx = o.OrderIdx
                 LEFT JOIN phi.EventItemManage AS ei
                        ON ei.EventItemManageIdx = ed.EventItemManageIdx
                       AND ed.ItemCategory = 'supplement'
                       AND ei.ProductIdx = 14
                     WHERE o.ProductGroupIdx = :productGroupIdx
                       AND mm.IsOut = b'0'
                       AND o.IsActive = b'1'
                       {$addSql}
                     GROUP BY o.OrderIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = $stmt->fetchAll();
            $this->setPagination(count($total), $param);

            $sql .= " ORDER BY ed.RegDatetime DESC ";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            $orderList = [];
            while ($row = $stmt->fetch()) {
                $this->data['data'][$row['OrderIdx']] = [
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'Name' => $row['Name'],
                    'Phone' => $row['Phone'],
                    'RegDatetime' => $row['RegDatetime'] ? substr($row['RegDatetime'], 0, 10) : '',
                    'DataContent' => [],
                ];

                $orderList[] = $row['OrderIdx'];
            }

            //맞춤영양 컨텐츠 조회
            if (count($orderList) > 0) {
                $orderListStr = implode(',', $orderList);

                $sql = " SELECT o.OrderIdx, ed.DataContent, ei.ItemNum, ed.EventItemManageIdx
                          FROM phi.UserEventData AS ed
                          JOIN phi.EventItemManage AS ei
                            ON ei.EventItemManageIdx = ed.EventItemManageIdx
                          JOIN order.Order AS o
                            ON o.OrderIdx = ed.OrderIdx
                         WHERE ed.ItemCategory = 'supplement'
                           AND o.ProductGroupIdx = :productGroupIdx
                           AND ei.ProductIdx = 14
                           AND ed.OrderIdx IN ({$orderListStr})";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
                $stmt->execute();
                $searchCol = [];
                while ($row = $stmt->fetch()) {
                    if (isset($this->data['data'][$row['OrderIdx']])) {
                        $this->data['data'][$row['OrderIdx']]['DataContent'][$row['ItemNum']] = $row['DataContent'];
                    }
                    $searchCol[$row['ItemNum']] = [
                        'text' => "맞춤영양{$row['ItemNum']}",
                        'value' => "ed.EventItemManageIdx_{$row['EventItemManageIdx']}"
                    ];
                }
                $this->data['select::searchColumn'] = $searchCol;
            }

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 설문 응답 조회
    function surveyList($param): array
    {
        $this->desc = 'model::surveyList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                switch ($param['keyword']) {
                    case 'm.Name':
                    case 'm.Phone':
                    case 'prm.CalcDate':
                    case 'ed.RegDatetime':
                        $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                        break;
                    case 'e.IsOut' :
                        if ($param['value'] === 'Y') {
                            $addSql .= " AND ed.UserEventDataIdx IS NULL AND prm.RegDatetime <= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
                        } else if ($param['value'] === 'N') {
                            $addSql .= " AND (ed.UserEventDataIdx IS NOT NULL OR prm.RegDatetime > DATE_SUB(NOW(), INTERVAL 1 HOUR))";
                        }
                        break;
                    default :
                        if (strpos($param['keyword'], 'ed.EventItemManageIdx_') !== false) {
                            $_k = explode('_', $param['keyword']);
                            $addSql .= " AND {$_k[0]} = {$_k[1]} AND ed.DataContent LIKE '%{$param['value']}%'";
                            break;
                        }
                        $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                        break;
                }
            }
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            // 유저 리스트 조회
            $sql = "     SELECT
                              m.Name, m.Phone
                            , prm.CalcDate, prm.RegDatetime AS CalcDatetime
                            , mm.MemberManageIdx
                            , o.OrderIdx
                            , p.ProductName, p.ProductIdx
                            , ed.RegDatetime AS EventDate, ed.UserEventDataIdx, ed.EventItemManageIdx, ed.DataContent, ed.ModDatetime
                          FROM phi.Member AS m
                          JOIN phi.MemberManage AS mm
                            ON mm.MemberIdx = m.MemberIdx
                          JOIN phi.ProductGroupManage AS pgm
                            ON pgm.ProductGroupIdx = 5
                          JOIN phi.Product AS p
                            ON p.ProductIdx = pgm.ProductIdx
                          JOIN order.Order AS o
                            ON o.MemberManageIdx = mm.MemberManageIdx
                          JOIN phi.PhiReportManage AS prm
                            ON prm.OrderIdx = o.OrderIdx
                           AND prm.MemberManageIdx = o.MemberManageIdx
                           AND prm.ReportType = 2  #질환예측
                     LEFT JOIN phi.UserEventData AS ed
                            ON ed.OrderIdx = o.OrderIdx
                           AND ed.MemberManageIdx = o.MemberManageIdx
                           AND ed.ItemCategory = 'survey'
                         WHERE p.ProductIdx = 8
                           AND o.ProductGroupIdx = :productGroupIdx
                           AND mm.IsOut = b'0'
                           AND o.IsActive = b'1'
                           {$addSql}
                      GROUP BY mm.MemberManageIdx, o.OrderIdx ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = $stmt->fetchAll();
            $this->setPagination(count($total), $param);

            $sql .= " ORDER BY ed.RegDatetime DESC ";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            $nowDatetime = strtotime(date('Y-m-d H:i:s'));
            $orderList = [];
            while ($row = $stmt->fetch()) {
                $outStatus = 'N';
                if (!$row['EventDate']) { //참여 이력이 없는 경우
                    $outStatus = 'Y';
                    $userRegTime = strtotime("+1 hours", strtotime($row['CalcDatetime']));
                    if ($nowDatetime < $userRegTime) { // 리포트 발급 1시간 이내인 경우 미이탈자 취급
                        $outStatus = 'N';
                    }
                }
                $this->data['data'][$row['OrderIdx']] = [
                    'Name' => $row['Name'],
                    'Phone' => $row['Phone'],
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'ProductIdx' => $row['ProductIdx'],
                    'ProductName' => $row['ProductName'],
                    'CalcDate' => $row['CalcDate'],
                    'EventDate' => $row['EventDate'] ? substr($row['EventDate'], 0, 10) : '',
                    'UserEventDataIdx' => $row['UserEventDataIdx'] ?? '',
                    'ModDatetime' => $row['ModDatetime'] ?? '',
                    'OutStatus' => $outStatus,
                    'Survey' => [],
                ];

                $orderList[] = $row['OrderIdx'];
            }

            // 설문 컨텐츠 조회
            if (count($orderList) > 0) {
                $orderListStr = implode(',', $orderList);
                $sql = "SELECT ed.OrderIdx, ei.ItemNum, ed.DataContent, ed.EventItemManageIdx
                      FROM phi.EventItemManage AS ei
                      JOIN phi.UserEventData AS ed
                        ON ed.EventItemManageIdx = ei.EventItemManageIdx
                     WHERE ei.ItemCategory = 'survey'
                       AND ei.ProductIdx = 8
                       AND ed.OrderIdx IN ({$orderListStr})";
                $stmt = $this->conn->query($sql);
                $searchCol = [];
                while ($row = $stmt->fetch()) {
                    if (isset($this->data['data'][$row['OrderIdx']])) { //유효 데이터만 취급
                        $this->data['data'][$row['OrderIdx']]['Survey'][$row['ItemNum']] = $row['DataContent'];
                    }
                    $searchCol[$row['ItemNum']] = [
                        'text' => "답변{$row['ItemNum']}",
                        'value' => "ed.EventItemManageIdx_{$row['EventItemManageIdx']}",
                    ];
                }
                $this->data['select::searchColumn'] = $searchCol;
            }
            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //설문 문항 수정
    function updateSurveyData($param): array
    {
        $this->desc = 'model::updateSurveyData';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param['memberManageIdx'], $param['orderIdx'], $param['productIdx'], $param['question'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }

            // 상담예약 여부 조회
            $sql = "  SELECT OrderIdx
                       FROM phi.UserLatestStatus
                      WHERE MemberManageIdx = :memberManageIdx
                        AND Orderidx = :orderIdx
                        AND ProductIdx = 4
                        AND `Process` = 'E'
                        AND StatusCode = '20000'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':memberManageIdx', $param['memberManageIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();
            if (!$row) {
                throw new \Exception("상담예약 미진행으로 등록할 수 없습니다.", "404");
            }

            $this->conn->beginTransaction();
            // 설문 동의 갱신
            $table = 'phi.AgreementManage';
            $idx = [
                'memberManageIdx' => $param['memberManageIdx'],
                'orderIdx' => $param['orderIdx'],
                'productIdx' => $param['productIdx']
            ];
            $item = [
                'memberManageIdx' => $param['memberManageIdx'],
                'orderIdx' => $param['orderIdx'],
                'productIdx' => $param['productIdx'],
                'aLL_AGRE_YN' => 'Y',
                'aGRE_DATE' => date('Y-m-d'),
            ];
            $this->insertDuplicate($idx, $table, $item, '');

            // 설문 문항 식별자 조회
            $sql = "SELECT ItemNum, EventItemManageIdx
                      FROM phi.EventItemManage
                     WHERE ItemCategory = 'survey'
                       AND ProductIdx = 8
                       AND Depth = 1
                  ORDER BY ItemNum ASC";
            $stmt = $this->conn->query($sql);
            $evtItemIdx = [];
            while ($row = $stmt->fetch()) {
                $evtItemIdx[] = $row['EventItemManageIdx'];
            }

            $item = [];
            if (count($param['question']) != count($evtItemIdx)) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', '400');
            }
            foreach ($evtItemIdx as $key => $idx) {
                $item[] = [
                    'orderIdx' => $param['orderIdx'],
                    'memberManageidx' => $param['memberManageIdx'],
                    'eventItemManageIdx' => (int)$idx,
                    'itemCategory' => 'survey',
                    'dataContent' => $param['question'][$key],
                ];
            }
            // 설문 컨텐츠 갱신
            $table = "phi.UserEventData";
            $this->bulkInsertUpdate([], $table, $item);

            // 최근 상태 갱신
            $table = "phi.UserLatestStatus";
            $idx = [
                'memberManageIdx' => $param['memberManageIdx'],
                'orderIdx' => $param['orderIdx'],
                'productIdx' => $param['productIdx']
            ];
            $item = [
                'memberManageIdx' => $param['memberManageIdx'],
                'orderIdx' => $param['orderIdx'],
                'productIdx' => $param['productIdx'],
                'process' => 'E',
                'statusCode' => '20000',
            ];
            $addUpdate = "LatestDatetime = NOW()";
            $this->insertDuplicate($idx, $table, $item, $addUpdate);

            $this->conn->commit();

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->conn = null;
            throw $e;
        }
    }

    // 알림톡 ProcessStep별 전송일 조회
    function searchSms($param): array
    {
        $this->desc = 'model::searchSms';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['memberManageIdx'], $param['orderIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }

            $sql = "SELECT
                        ProcessStep, SendDate
                    FROM sms.SendResult
                    WHERE (MemberManageIdx, OrderIdx) = (:memberManageIdx, :orderIdx)
                    ORDER BY SendDate ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':memberManageIdx', $param['memberManageIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $this->data = [
                'registerBizMDate' => '',
                'diseaseBizMDate' => '',
                'geneticBizMDate' => '',
                'consultBizMDate' => '',
                'leaveBizMDate' => '',
                'laterBizMDate' => '',
                'notResponseBizMDate' => '',
                'reportBizMDate' => ''
            ];
            while ($row = $stmt->fetch()) {
                switch ($row['ProcessStep']) {
                    case '21':
                    case '31':
                        $this->data['registerBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    case '22':
                    case '33':
                        $this->data['diseaseBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    case '23':
                        $this->data['geneticBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    case '24':
                    case '35':
                        $this->data['consultBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    case '32':
                        $this->data['leaveBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    case '36':
                        $this->data['laterBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    case '37':
                        $this->data['notResponseBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    case '38':
                        $this->data['reportBizMDate'] = substr($row['SendDate'], 0, 10);
                        break;
                    default:
                        break;
                }
            }

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 알림톡 조회
    function smsList($param): array
    {
        $this->desc = "model::smsList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            $addCountSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['o.RegDatetime', 'm.Name', 'm.Phone'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else if (strpos($param['keyword'], 'BizM') !== false) {
                    $_k = explode('-', $param['keyword']);
                    $addCountSql = " AND sm.ProcessStep = {$_k[1]}";
                    if($param['value'] === 'Y') {
                        $addSql .= " AND sm.SendCount > 0";
                    } else {
                        $addSql .= " AND sm.SendCount IS NULL";
                    }
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            // 대상 전체 카운트
            $sql = "SELECT DISTINCT o.OrderIdx
                    FROM order.Order AS o
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.ClientCustomerManage AS ccm
                      ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
               LEFT JOIN sms.SendManage AS sm
                      ON (sm.MemberManageIdx, sm.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                    {$addCountSql}
                   WHERE mm.IsOut = b'0' #탈퇴회원 제외
                     AND o.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
                     AND o.IsActive = b'1' #활성회원 선별
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql = "
            	WITH targetOrder as (
		            SELECT DISTINCT o.OrderIdx, o.RegDatetime, o.MemberManageIdx, o.ProductGroupIdx
		            FROM order.Order AS o
		            JOIN phi.MemberManage AS mm
			        ON mm.MemberManageIdx = o.MemberManageIdx
		            JOIN phi.ClientCustomerManage AS ccm
			        ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                    JOIN phi.Member AS m
			        ON m.MemberIdx = mm.MemberIdx
                    LEFT JOIN sms.SendManage AS sm
			        ON (sm.MemberManageIdx, sm.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
			        {$addCountSql}
                    WHERE mm.IsOut = b'0' #탈퇴회원 제외
			        AND o.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
			        AND o.IsActive = b'1' #활성회원 선별
			        {$addSql}
			        ORDER BY o.RegDatetime DESC
		            LIMIT :start, :entry
	                ),
                targetSmsData as  (
		            SELECT
                    o.RegDatetime, o.MemberManageIdx, o.OrderIdx,
                    sm.ProcessStep, m.Name, tm.MemberIdx AS TestMember
                    FROM targetOrder AS o
                    JOIN phi.MemberManage AS mm
                    ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.Member AS m
                    ON m.MemberIdx = mm.MemberIdx
                    LEFT JOIN phi.TestMember AS tm
                    ON tm.MemberIdx = m.MemberIdx
				    LEFT JOIN sms.SendManage AS sm
                    ON (sm.MemberManageIdx, sm.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                    WHERE o.ProductGroupIdx = :productGroupIdx
                )
                select * FROM targetSmsData
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (!isset($data[$item['OrderIdx']])) {
                    switch ($param['gIdx']) {
                        case "2":
                            $data[$item['OrderIdx']] = ['MemberManageIdx' => $item['MemberManageIdx'],
                                'OrderIdx' => $item['OrderIdx'],
                                'Name' => $item['Name'],
                                'RegisterBizM' => $item['ProcessStep'] === '21',
                                'DiseaseBizM' => $item['ProcessStep'] === '22',
                                'GeneticBizM' => $item['ProcessStep'] === '23',
                                'ConsultBizM' => $item['ProcessStep'] === '24',
                                'TestMember' => $item['TestMember'],
                                'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',];
                            break;
                        case "5":
                            $data[$item['OrderIdx']] = ['MemberManageIdx' => $item['MemberManageIdx'],
                                'OrderIdx' => $item['OrderIdx'],
                                'Name' => $item['Name'],
                                'RegisterBizM' => $item['ProcessStep'] === '31', //신청완료
                                'LeaveBizM' => $item['ProcessStep'] === '32', //이탈발생
                                'DiseaseBizM' => $item['ProcessStep'] === '33', //요약검사결과
                                'ReDiseaseBizM' => $item['ProcessStep'] === '34', //요약검사결과 재발송
                                'ConsultBizM' => $item['ProcessStep'] === '35', //상담사 설명
                                'LaterBizM' => $item['ProcessStep'] === '36', //나중에 결정
                                'NotResponseBizM' => $item['ProcessStep'] === '37', //미응답
                                'ReportBizM' => $item['ProcessStep'] === '38', //결과지 View
                                'TestMember' => $item['TestMember'],
                                'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',];
                            break;
                    }
                    continue;
                }

                switch ($param['gIdx']) {
                    case "2":
                        $target = [
                            '21' => 'RegisterBizM',
                            '22' => 'DiseaseBizM',
                            '23' => 'GeneticBizM',
                            '24' => 'ConsultBizM'
                        ];
                        break;
                    case "5":
                        $target = [
                            '31' => 'RegisterBizM',
                            '32' => 'LeaveBizM',
                            '33' => 'DiseaseBizM',
                            '34' => 'ReDiseaseBizM',
                            '35' => 'ConsultBizM',
                            '36' => 'LaterBizM',
                            '37' => 'NotResponseBizM',
                            '38' => 'ReportBizM',
                        ];
                        break;
                }



                if (!isset($target[$item['ProcessStep']])) {
                    continue;
                }
                $data[$item['OrderIdx']][$target[$item['ProcessStep']]] = true;

            }

            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //상담예약 수정
    function updateConsultingData($param): array
    {
        $this->desc = 'model::updateConsultingData';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['memberManageIdx'], $param['orderIdx'], $param['productIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            if (
                !preg_match($this->pattern['num'], $param['memberManageIdx'])
                || !preg_match($this->pattern['num'], $param['orderIdx'])
                || !preg_match($this->pattern['num'], $param['productIdx'])
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', '400');
            }

            switch ($param['gIdx']) {
                case "2":
                    $url = api . "/register/consult";
                    $data = [
                        'MemberManageIdx' => $param['memberManageIdx'],
                        'AppointmentHour' => $param['appointmentHour'],
                        'AppointmentDay' => $param['appointmentDay'],
                        'AllAgreeYn' => 'Y',
                        'AgreeDate' => date('Y-m-d')
                    ];
                    $result = $this->curl("POST", $url, [], $data);
                    if ($result['code'] === 200) {
                        return $this->response();
                    } else {
                        throw new \Exception('통신 실패', '450');
                    }

                    break;
                default :
                    $sql = "    SELECT OrderIdx
                                  FROM phi.UserEventData
                                 WHERE ItemCategory = 'supplement'
                                   AND Orderidx = :orderIdx
                                   AND MemberManageIdx = :memberManageIdx";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
                    $stmt->bindValue(':memberManageIdx', $param['memberManageIdx'], $this->conn::PARAM_INT);
                    $stmt->execute();
                    $data = $stmt->fetch();
                    if (!$data) {
                        // PHI - 질병예측결과 데이터 불러오기
                        $sql = "SELECT
                                    M.Gender, PRM.ReportType, PRM.Uuid, PRM.Data, PRM.ExamDate
                                FROM phi.PhiReportManage PRM
                                JOIN phi.MemberManage MM ON MM.MemberManageIdx = PRM.MemberManageIdx
                                JOIN phi.Member M ON M.MemberIdx = MM.MemberIdx
                                WHERE (PRM.MemberManageIdx, PRM.OrderIdx) = (:memberManageIdx, :orderIdx)
                                AND PRM.ReportType = 2
                                ORDER BY PRM.NhisPreviewListIdx DESC, PRM.ExamDate DESC
                                LIMIT 1";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindValue(':memberManageIdx', $param['memberManageIdx'], $this->conn::PARAM_INT);
                        $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
                        $stmt->execute();
                        $row = $stmt->fetch($this->conn::FETCH_ASSOC);
                        if (!$row) {
                            throw new \Exception("질병예측 검사결과를 찾을 수 없습니다.", "404");
                        }

                        $gender = (int)$row['Gender'];
                        $phiData = json_decode($row['Data'], true);
                        $phiResult = [];
                        foreach ($phiData as $key => $row) {
                            if (in_array($key, [11,12,15,16,24])){
                                $dataName = $this->bioMarkerCode[$key];
                                $stat = $this->bioMarkerGradeCovert($row['rrisk']);

                                $phiResult['level'][$dataName['title']] = $stat;
                                $phiResult['percentage'][$dataName['title']] = floor($this->bioMarkerPercentCovert($row['rrisk'])) . "%";
                            }
                        }

                        arsort($phiResult['percentage']);

                        $recommendSupplements = $this->generateSupplements($phiResult, $gender);

                        // 맞춤영양추천 Event 입력
                        // EventItemManageIdx 불러오기
                        $sql = "SELECT ProductIdx, EventItemManageIdx, ItemCategory FROM phi.EventItemManage
                                WHERE ItemCategory = 'supplement'
                                ORDER BY ItemNum ASC";
                        $stmt = $this->conn->query($sql);

                        // Insert Value 생성하기
                        $placeholder = [];
                        $i = 0;
                        while ($row = $stmt->fetch($this->conn::FETCH_ASSOC)) {
                            $suppleProductIdx = (int)$row['ProductIdx'];
                            $eventIdx = (int)$row['EventItemManageIdx'];
                            $itemCategory = $row['ItemCategory'];

                            $placeholder[] = "(:memberManageIdx, :orderIdx, {$eventIdx}, '{$itemCategory}', '{$recommendSupplements[$i]}')";
                            $i++;
                        }

                        $placeholders = implode(",", $placeholder);
                        $sql = "INSERT INTO phi.UserEventData (
                                    MemberManageIdx, OrderIdx, EventItemManageIdx, ItemCategory, DataContent)
                                VALUES {$placeholders}
                                ON DUPLICATE KEY UPDATE
                                    ItemCategory = VALUE(ItemCategory),
                                    DataContent = VALUE(DataContent),
                                    ModDatetime = NOW()";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindValue(':memberManageIdx', $param['memberManageIdx'], $this->conn::PARAM_INT);
                        $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
                        $stmt->execute();

                        //상태정보 갱신
                        $sql = "UPDATE phi.UserLatestStatus
                                   SET `Process` = 'E', `StatusCode` = '20000'
                                 WHERE (MemberManageIdx, OrderIdx) = (:memberManageIdx, :orderIdx)
                                   AND ProductIdx = 14";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindValue(':memberManageIdx', $param['memberManageIdx'], $this->conn::PARAM_INT);
                        $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
                        $stmt->execute();
                    }

                    $this->conn->beginTransaction();

                    // 상담 동의 갱신
                    $table = 'phi.AgreementManage';
                    $idx = [
                        'memberManageIdx' => $param['memberManageIdx'],
                        'orderIdx' => $param['orderIdx'],
                        'productIdx' => $param['productIdx']
                    ];
                    $item = [
                        'memberManageIdx' => $param['memberManageIdx'],
                        'orderIdx' => $param['orderIdx'],
                        'productIdx' => $param['productIdx'],
                        'aLL_AGRE_YN' => 'Y',
                        'aGRE_DATE' => date('Y-m-d'),
                    ];
                    $this->insertDuplicate($idx, $table, $item, '');

                    // 상담 정보 갱신
                    $table = 'phi.ConsultingStatus';
                    $idx = [
                        'memberManageIdx' => $param['memberManageIdx'],
                        'orderIdx' => $param['orderIdx'],
                    ];
                    $item = [
                        'memberManageIdx' => $param['memberManageIdx'],
                        'orderIdx' => $param['orderIdx'],
                        'appointmentHour' => $param['appointmentHour'] !== '' ? (int)$param['appointmentHour'] : '',
                        'appointmentDay' => $param['appointmentDay'] !== '' ? (int)$param['appointmentDay'] : '',
                    ];
                    $addUpdate = "ModDatetime = '" . date('Y-m-d H:i:s') . "'";
                    if($param['appointmentHour'] !== ''){
                        $addUpdate .= ", AppointmentHour = {$param['appointmentHour']}";
                    }
                    if($param['appointmentDay'] !== '') {
                        $addUpdate .= ", AppointmentDay = {$param['appointmentDay']}";
                    }

                    $this->insertDuplicate($idx, $table, $item, $addUpdate);

                    // 최근 상태 갱신
                    $table = "phi.UserLatestStatus";
                    $idx = [
                        'memberManageIdx' => $param['memberManageIdx'],
                        'orderIdx' => $param['orderIdx'],
                        'productIdx' => $param['productIdx']
                    ];
                    $item = [
                        'memberManageIdx' => $param['memberManageIdx'],
                        'orderIdx' => $param['orderIdx'],
                        'productIdx' => $param['productIdx'],
                        'process' => 'E',
                        'statusCode' => '20000',
                    ];
                    $addUpdate = "LatestDatetime = '" . date('Y-m-d H:i:s') . "'";
                    $this->insertDuplicate($idx, $table, $item, $addUpdate);

                    $this->conn->commit();
                    $this->conn = null;
                    return $this->response();
                    break;
            }
        } catch (\Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->conn = null;
            throw $e;
        }
    }

    // 맞춤영양추천 알고리즘
    public function generateSupplements($phiResult, int $gender): array
    {
        $recommendSupplements = [];

        $level = $phiResult['level'];
        $percentage = $phiResult['percentage'];

        $top3BiomarkerPercentage = array_slice($percentage,0,3);
        if (in_array('췌장암', array_keys($top3BiomarkerPercentage)) && in_array('당뇨병', array_keys($top3BiomarkerPercentage))) {
            $top3BiomarkerPercentage = array_slice($percentage,0,4);
        }
        $top3Biomarker = array_keys($top3BiomarkerPercentage);
        foreach ($top3Biomarker as $val) {
            if ($val === '신장질환') {
                $recommendSupplements[] = $this->supplements[$val][$gender][$level[$val]];
            } else {
                $recommendSupplements[] = $this->supplements[$val][$level[$val]];
            }
        }

        $supplements = array_values(array_unique($recommendSupplements));

        return $supplements;
    }

    // biomarker rrisk-위험도 코딩 규칙
    public function bioMarkerGradeCovert($rRisk)
    {
        $target = [1, 1.15, 1.3, 1.5];
        $name = ["양호", "주의", "경고", "위험"];

        $result = "";
        foreach ($target as $key => $row) {
            if ($rRisk <= $row) {
                $result = $name[$key];
                break;
            }
        }
        return ($result !== "") ? $result : "고위험";
    }

    // biomarker rrisk-퍼센트 변환
    public function bioMarkerPercentCovert($rRisk)
    {
        if ($rRisk > 1.9) {
            return 90;
        } else if ($rRisk > 1) {
            return ($rRisk - 1) * 100;
        } else if ($rRisk == 1) {
            return 0;
        } else {
            return -(1 - $rRisk) * 100;
        }
    }

    //상담예약 조회
    // 상품그룹: 얼리큐, 상품: 보험상담
    function consultingList($param): array
    {
        $this->desc = 'model::consultingList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                switch ($param['keyword']) {
                    case 'm.Name':
                    case 'm.Phone':
                    case 'prm.CalcDate':
                        $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                        break;
                    case 'cs.IsOut' :
                        if ($param['value'] === 'Y') {
                            $addSql .= " AND (cs.AppointmentDay = '' OR cs.AppointmentDay IS NULL ) AND (cs.AppointmentHour = '' OR cs.AppointmentHour IS NULL) AND prm.RegDatetime <= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
                        } else if ($param['value'] === 'N') {
                            $addSql .= " AND ((cs.AppointmentDay != ''  AND cs.AppointmentHour != '') OR prm.RegDatetime > DATE_SUB(NOW(), INTERVAL 1 HOUR))";
                        }
                        break;
                    case 'cs.IsAgree' :
                        if ($param['value'] === 'Y') {
                            $addSql .= " AND cs.AppointmentDay != ''  AND cs.AppointmentHour != ''";
                        } else if ($param['value'] === 'N') {
                            $addSql .= " AND (cs.AppointmentDay = '' OR cs.AppointmentDay IS NULL ) AND (cs.AppointmentHour = '' OR cs.AppointmentHour IS NULL)";
                        }
                        break;
                    default :
                        $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                        break;
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                if ($param['column'] === 'IsOut') {
                    $orderSql .= " cs.AppointmentHour {$param['sort']}, prm.RegDatetime {$param['sort']} ";
                } else if ($param['column'] === 'IsAgree') {
                    $orderSql .= " cs.AppointmentHour {$param['sort']} ";
                } else {
                    $orderSql .= " {$param['column']} {$param['sort']} ";
                }
            } else {
                $orderSql .= ' prm.RegDatetime DESC, prm.NhisPreviewListIdx DESC ';
            }

            $sql = " SELECT
                          m.Name, m.Phone
                        , mm.MemberManageIdx
                        , o.OrderIdx
                        , prm.CalcDate, prm.RegDatetime as CalcDatetime
                        , pgm.ProductIdx
                        , p.ProductName
                        , cs.AppointmentHour, cs.AppointmentDay, cs.ConsultantType
                        , cs.RegDatetime
                      FROM phi.Member AS m
                      JOIN phi.MemberManage AS mm
                        ON mm.MemberIdx = m.MemberIdx
                      JOIN order.Order AS o
                        ON o.MemberManageIdx = mm.MemberManageIdx
                      JOIN phi.ProductGroupManage AS pgm
                        ON pgm.ProductGroupIdx = :productGroupIdx
                      JOIN phi.Product AS p
                        ON p.ProductIdx = pgm.ProductIdx
                 LEFT JOIN phi.ConsultingStatus AS cs
                        ON cs.MemberManageIdx = o.MemberManageIDx
                       AND cs.OrderIdx = o.OrderIdx
                      JOIN phi.PhiReportManage AS prm
                        ON prm.OrderIdx = o.OrderIdx
                       AND prm.MemberManageIdx = o.MemberManageIdx
                     WHERE p.ProductIdx = 4
                       AND o.ProductGroupIdx = :productGroupIdx
                       AND prm.ReportType = 2 #질환예측
                       AND mm.IsOut = b'0'
                       AND o.IsActive = b'1'
                       {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $total = count($row);
            $this->setPagination($total, $param);

            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();

            $nowDatetime = strtotime(date('Y-m-d H:i:s'));
            while ($row = $stmt->fetch()) {
                $userRegTime = strtotime("+1 hours", strtotime($row['CalcDatetime']));
                $outStatus = 'N';
                $consultAgree = 'N';
                if ((!$row['AppointmentDay'] || !$row['AppointmentHour'])) {
                    if ($nowDatetime > $userRegTime) { // 리포트 발급 1시간 이내인 경우 미이탈자 취급
                        $outStatus = 'Y';
                    }
                } else {
                    $consultAgree = 'Y';
                }
                $this->data['data']["idx{$row['OrderIdx']}"] = [
                    'CalcDate' => $row['CalcDate'],
                    'ReservationDate' => $row['RegDatetime'] ? substr($row['RegDatetime'], 0, 10) : '',
                    'MemberManageIdx' => $row['MemberManageIdx'],
                    'OrderIdx' => $row['OrderIdx'],
                    'Name' => $row['Name'],
                    'Phone' => $row['Phone'],
                    'OutStatus' => $outStatus,
                    'ConsultAgree' => $consultAgree,
                    'AppointmentDay' => $row['AppointmentDay'],
                    'AppointmentHour' => $row['AppointmentHour'],
                    'ProductIdx' => $row['ProductIdx'],
                ];
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 전화상담 조회
    function telephoneList($param): array
    {
        $this->desc = "model::telephoneList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['o.RegDatetime', 'm.Name', 'm.Phone'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    if ($param['keyword'] === 'culs.StatusCode') {
                        switch ($param['value']) {
                            case 'Y':
                                $addSql .= " AND ({$param['keyword']} <> '20000' OR {$param['keyword']} IS NULL)";
                                break;
                            case 'N':
                                $addSql .= " AND {$param['keyword']} = '20000'";
                                break;
                        }
                    } else if ($param['keyword'] === 'am.ALL_AGRE_YN') {
                        switch ($param['value']) {
                            case 'Y':
                                $addSql .= " AND {$param['keyword']} = 'Y'";
                                break;
                            case 'N':
                                $addSql .= " AND ({$param['keyword']} <> 'Y' OR {$param['keyword']} IS NULL)";
                                break;
                        }
                    } else if ($param['keyword'] === 'cs.AppointmentDay') {
                        switch ($param['value']) {
                            case '평일':
                                $param['value'] = '1';
                                break;
                            case '주말':
                                $param['value'] = '6';
                                break;
                            case '항상가능':
                                $param['value'] = '8';
                                break;
                        }
                        $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                    } else {
                        $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                    }
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']} ";
            } else {
                $orderSql .= ' o.RegDatetime DESC ';
            }

            $data = [];
            // 대상 전체 카운트
            $sql = "SELECT
                       o.RegDatetime, o.MemberManageIdx, o.OrderIdx,
                       culs.Process, culs.StatusCode,
                       cs.AppointmentDay, cs.AppointmentHour, am.ALL_AGRE_YN,
                       m.Name, m.Phone, tm.MemberIdx AS TestMember
                    FROM order.Order AS o
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
               LEFT JOIN phi.ConsultingStatus AS cs
                      ON (cs.MemberManageIdx, cs.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
               LEFT JOIN phi.UserLatestStatus AS culs
                      ON (culs.MemberManageIdx, culs.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                     AND culs.ProductIdx = 4
               LEFT JOIN phi.AgreementManage AS am
                      ON (am.MemberManageIdx, am.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                     AND am.ProductIdx = 4
                   WHERE mm.IsOut = b'0'
                     AND o.ProductGroupIdx = :productGroupIdx
                     AND o.IsActive = b'1'
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $data["idx{$item['OrderIdx']}"] = [
                    'MemberManageIdx' => $item['MemberManageIdx'],
                    'OrderIdx' => $item['OrderIdx'],
                    'Process' => $item['Process'],
                    'StatusCode' => $item['StatusCode'],
                    'Name' => $item['Name'],
                    'Phone' => $item['Phone'],
                    'AppointmentDay' => $item['AppointmentDay'],
                    'AppointmentHour' => $item['AppointmentHour'],
                    'ALL_AGRE_YN' => $item['ALL_AGRE_YN'],
                    'TestMember' => $item['TestMember'],
                    'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                ];
            }

            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 유전자검사 신청서 발송오류 조회
    function agreementFailList($param): array
    {
        $this->desc = "model::agreementFailList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $data = [];
            // 대상 전체 카운트
            $sql = "SELECT
                       apsel.RegDatetime, apsel.MemberManageIdx, apsel.OrderIdx,
                       ccm.ClientCustomerManageIdx, ccm.ClientCustomerName,
                       m.Name, tm.MemberIdx AS TestMember
                    FROM phi.AgreementPaperSendErrorList AS apsel
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = apsel.MemberManageIdx
                    JOIN phi.ClientCustomerManage AS ccm
                      ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                    JOIN order.Order AS o
                      ON o.OrderIdx = apsel.OrderIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
                   WHERE mm.IsOut = b'0'
                     AND o.ProductGroupIdx = :productGroupIdx
                     AND o.IsActive = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            // 최근 상태 조회
            $sql .= " ORDER BY apsel.RegDatetime DESC ";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $data[$item['OrderIdx']] = [
                    'MemberManageIdx' => $item['MemberManageIdx'],
                    'OrderIdx' => $item['OrderIdx'],
                    'ClientCustomerManageIdx' => $item['ClientCustomerManageIdx'],
                    'ClientCustomerName' => $item['ClientCustomerName'],
                    'Name' => $item['Name'],
                    'TestMember' => $item['TestMember'],
                    'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                ];
            }

            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 유전자검사 신청서 다운로드
    function getGeneticAgreement($param): void
    {
        try {
            if (!isset($param['orderIdx'])) {
                throw new \Exception("필수 파라미터가 존재하지 않습니다.", "404");
            }

            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $sql = "SELECT
                        gcmi.MemberManageIdx, gcmi.OrderIdx, gcmi.AgreementPaperDir,
                        am.AGRE_DATE, og.OrderingIdx, m.Name
                    FROM phi.GeneticCompanyMemberInfo gcmi
                    JOIN phi.AgreementManage am
                      ON (am.MemberManageIdx, am.OrderIdx) = (gcmi.MemberManageIdx, gcmi.OrderIdx)
                    JOIN phi.MemberManage mm
                      ON mm.MemberManageIdx = gcmi.MemberManageIdx
                    JOIN phi.Member m
                      ON m.MemberIdx = mm.MemberIdx
                    JOIN order.Ordering og
                      ON og.OrderIdx = gcmi.OrderIdx
                   WHERE gcmi.OrderIdx = :orderIdx
                     AND am.ProductIdx IN (5,6)
                     AND og.ProductIdx IN (5,6)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];
            if (!$row) {
                throw new \Exception("유전자검사 데이터가 조회되지 않습니다.", "404");
            }
            $agreeDate = date('Ymd', strtotime($row['AGRE_DATE']));
            $filename = $row['AgreementPaperDir'];
            if (!$filename) {
                $filename = "/api-service/priv/genetic-agreement/";
                $filename .= "{$agreeDate}_{$row['MemberManageIdx']}_{$row['OrderIdx']}";
            }
            $dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
            array_pop($dir);
            array_pop($dir);
            $dir = implode('/', $dir);
            $agreementDir = "{$dir}/image{$filename}";
            if (!file_exists($agreementDir)) {
                $filename = "/api-service/priv/genetic-agreement/";
                $filename .= "{$agreeDate}_{$row['MemberManageIdx']}_{$row['OrderingIdx']}.png";
                $agreementDir = "{$dir}/image{$filename}";
            }
            if (!file_exists($agreementDir)) {
                throw new \Exception("유전자검사 신청서 파일을 찾을 수 없습니다.", "404");
            }

            $agreementFile = file_get_contents($agreementDir, FILE_USE_INCLUDE_PATH);

            $downloadName = "{$row['MemberManageIdx']}_{$row['Name']}_유전자검사신청서.png";

            header("Pragma: public");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename={$downloadName}");
            header("Content-Transfer-Encoding: binary");

            echo $agreementFile;
            exit;

        } catch (\Exception $e) {
            alert($e->getMessage());
            echo "<script>window.close();</script>";
            exit;
        }
    }

    // 유전자검사신청 조회
    function geneticList($param): array
    {
        $this->desc = "model::geneticList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['o.RegDatetime', 'ccm.ClientCustomerName', 'm.Name', 'gcmi.GCRegDate'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    if (in_array($param['keyword'], ['ccm.ResponseType', 'gcmi.IsSend'])) {
                        switch ($param['value']) {
                            case '이메일':
                                $param['value'] = '1';
                                break;
                            case '직접출력':
                                $param['value'] = '2';
                                break;
                            case 'Y':
                            case 'y':
                                $param['value'] = "b'1'";
                                break;
                            case 'N':
                            case 'n':
                                $param['value'] = "b'0'";
                                break;
                            default:
                                $param['value'] = null;
                        }
                    }
                    if ($param['value']) {
                        $addSql .= " AND {$param['keyword']} = {$param['value']}";
                    }
                }
            }

            $data = [];
            // 대상 전체 카운트
            $sql = "SELECT
                       o.RegDatetime, gcmi.MemberManageIdx, gcmi.OrderIdx, gcmi.GCRegNo, gcmi.GCRegDate,
                       gcmi.AgreementPaperDir, gcmi.IsSend,
                       ccm.ClientCustomerName, ccm.ResponseType,
                       m.Name, tm.MemberIdx AS TestMember
                    FROM phi.GeneticCompanyMemberInfo AS gcmi
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = gcmi.MemberManageIdx
                    JOIN phi.ClientCustomerManage AS ccm
                      ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                    JOIN order.Order AS o
                      ON o.OrderIdx = gcmi.OrderIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
                   WHERE mm.IsOut = b'0'
                     AND o.ProductGroupIdx = :productGroupIdx
                     AND o.IsActive = b'1'
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            // 최근 상태 조회
            $sql .= " ORDER BY o.RegDatetime DESC ";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $data[$item['OrderIdx']] = [
                    'MemberManageIdx' => $item['MemberManageIdx'],
                    'OrderIdx' => $item['OrderIdx'],
                    'ClientCustomerName' => $item['ClientCustomerName'],
                    'ResponseType' => $item['ResponseType'],
                    'Name' => $item['Name'],
                    'GCRegNo' => $item['GCRegNo'],
                    'GCRegDate' => $item['GCRegDate'],
                    'IsSend' => $item['IsSend'],
                    'AgreementPaperDir' => $item['AgreementPaperDir'],
                    'TestMember' => $item['TestMember'],
                    'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                ];
            }

            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // IB 리포트 다운로드
    function getIbReport($param): void
    {
        try {
            if (!isset($param['orderIdx'], $param['tCode'])) {
                throw new \Exception("필수 파라미터가 존재하지 않습니다.", "404");
            }
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $sql = "SELECT
                        o.MemberManageIdx, o.OrderIdx,
                        m.Name, m.Gender, m.Birth1, m.Birth2
                    FROM order.Order o
                    JOIN phi.MemberManage mm
                      ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.Member m
                      ON m.MemberIdx = mm.MemberIdx
                    WHERE o.OrderIdx = :orderIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch($this->conn::FETCH_ASSOC);
            if (!$row) {
                throw new \Exception("주문 정보가 조회되지 않습니다.", "404");
            }

            $memberManageIdx = (int)$row['MemberManageIdx'];
            $orderIdx = (int)$row['OrderIdx'];
            $name = $row['Name'];
            $gender = $row['Gender'] === '1' ? '남' : ($row['Gender'] === '2' ? '여' : '');
            $age = convertAging($row['Birth1'] . $row['Birth2'], date('Y-m-d'));
            $downloadName = "{$memberManageIdx}_{$name}_{$gender}_{$age}.pdf";

            if ($param['tCode'] === '2') {
                $sql = "INSERT IGNORE INTO phi.MemberTransferStatus (
                            MemberManageIdx, OrderIdx, IsComplete)
                        VALUES ({$memberManageIdx}, {$orderIdx}, b'1')";
                $this->conn->query($sql);
            }

            $filename = "{$memberManageIdx}_{$orderIdx}_{$param['gIdx']}.pdf";

            $dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
            array_pop($dir);
            array_pop($dir);
            $dir = implode('/', $dir);

            $pdfPath = "{$dir}/image/datashare/priv/ibReport/{$filename}";

            if (!file_exists($pdfPath)) {
                $userData = $this->getIbData($param);
                (new Pdf())->createIbPdf($userData);
            }

            $pdfFile = file_get_contents($pdfPath, FILE_USE_INCLUDE_PATH);

            header('Cache-Control: no-cache,no-store,max-age=0,must-revalidate');
            header('Content-Disposition: attachment; filename="' . $downloadName . '"');
            header('Content-Length: ' . strlen($pdfFile));
            header('Content-type: application/pdf;charset=UTF-8');
            header('Expires: 0');

            $this->conn = null;
            echo $pdfFile;
            exit;

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // IB결과지 가져오기 및 생성
    private function getIbData($param)
    {
        try {
            if (!in_array($param['gIdx'], ['2', '5'])) {
                throw new \Exception('IB결과지가 제공되지 않은 상품그룹입니다.', '400');
            }

            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            // 필요 데이터 가져오기
            $userData = [];

            // 회원정보 조회
            $sql = "SELECT
                        o.MemberManageIdx, o.OrderIdx, o.ProductGroupIdx,
                        m.Name, m.Gender, m.Birth1, m.Birth2, m.Phone, m.State, m.City, m.FullCity, m.Email,
                        ccm.ClientCustomerName, ccm.ResponseType,
                        ccm.State AS ClientState, ccm.City AS ClientCity, ccm.FullCity AS ClientFullCity,
                        cs.AppointmentDay, cs.AppointmentHour, cs.AppointmentDate, cs.ConsultantType,
                        ued.EventProcess
                    FROM order.Order o
                    JOIN phi.MemberManage mm
                      ON mm.MemberManageIdx = o.MemberManageIdx
                    JOIN phi.Member m
                      ON m.MemberIdx = mm.MemberIdx
                    JOIN phi.ClientCustomerManage ccm
                      ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                    JOIN phi.ConsultingStatus cs
                      ON (cs.MemberManageIdx, cs.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                    -- 할당된 회원만 IB결과지 다운로드 가능
                    JOIN phi.MemberAllocationManage mam
                      ON (mam.MemberManageIdx, mam.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
               LEFT JOIN phi.UserEventData ued
                      ON (ued.MemberManageIdx, ued.OrderIdx) = (o.MemberManageIdx, o.OrderIdx)
                     AND ued.ItemCategory = 'personal_link'
                   WHERE o.OrderIdx = {$param['orderIdx']}
                     AND mm.IsOut = b'0'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $memberData = $stmt->fetch($this->conn::FETCH_ASSOC);
            if (!$memberData) {
                throw new \Exception('회원정보를 찾을 수 없습니다.', '404');
            }
            $memberManageIdx = $memberData['MemberManageIdx'];
            $orderIdx = $memberData['OrderIdx'];

            $memberData['Age'] = convertAging($memberData['Birth1'] . $memberData['Birth2'], date('Y-m-d'));
            $memberData['Birth'] = date('Y.m.d', strtotime($memberData['Birth1'] . $memberData['Birth2']));
            $memberData['GenderStr'] = $memberData['Gender'] === '1' ? '남' : ($memberData['Gender'] === '2' ? '여' : '');

            $userData['memberData'] = $memberData;

            // PHI 결과 조회
            $sql = "SELECT
                        Data, Uuid, ReportType, ExamDate
                    FROM phi.PhiReportManage
                   WHERE (MemberManageIdx, OrderIdx) = ({$memberManageIdx}, {$orderIdx})
                     AND ReportType = 2
                ORDER BY ExamDate DESC
                   LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $item = $stmt->fetch($this->conn::FETCH_ASSOC);
            if (!$item) {
                throw new \Exception('질병예측검사 결과를 찾을 수 없습니다.', '404');
            }
            $phiData = json_decode($item['Data'], true);
            $phiResult = [];
            if (count($phiData) === 0) {
                throw new \Exception("질병예측검사 결과가 없습니다.", '404');
            }
            foreach ($phiData as $key => $row) {
                $dataName = $this->bioMarkerCode[$key];
                $stat = $this->bioMarkerGradeCovert($row['rrisk']);
                $phiResult[$stat][$dataName['title']] = floor($this->bioMarkerPercentCovert($row['rrisk'])) . "%";
            }
            $userData['phiData'] = $phiResult;
            switch ($param['gIdx']) {
                // 질병예측 IB결과지
                case '2':
                    # 유전자 검사결과 조회
                    $sql = "SELECT
                                grl.OrderIdx, grl.ResultCode, pc.CatalogName
                            FROM phi.GeneticResultList grl
                            JOIN phi.ProductCatalog pc
                              ON pc.ProductCatalogIdx = grl.ProductCatalogIdx
                           WHERE grl.ResultCode IN ('H', 'A', 'L')
                             AND (grl.MemberManageIdx, grl.OrderIdx) = ({$memberManageIdx}, {$orderIdx})";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    $geneticResult = $stmt->fetchAll($this->conn::FETCH_ASSOC) ?? [];
                    if (count($geneticResult) === 0) {
                        throw new \Exception('유전자 검사결과를 찾을 수 없습니다.', '404');
                    }

                    $geneResult = [
                        'H' => [],
                        'A' => [],
                        'L' => []
                    ];
                    foreach ($geneticResult as $item) {
                        $geneResult[$item['ResultCode']][] = $item['CatalogName'];
                    }

                    $userData['geneResult'] = $geneResult;

                    break;
                // 얼리큐 IB결과지
                case '5':
                    # 설문문항 조회
                    $sql = "SELECT
                                EventItemManageIdx, Content, Depth, ParentEventItemManageIdx, ItemNum
                            FROM phi.EventItemManage
                           WHERE ItemCategory = 'survey'
                        ORDER BY Depth ASC, ParentEventItemManageIdx ASC, ItemNum ASC";
                    $stmt = $this->conn->query($sql);
                    $surveyQ = [];
                    while ($item = $stmt->fetch()) {
                        if($item['Depth'] === '1') {
                            $surveyQ['question'][$item['EventItemManageIdx']] = "{$item['ItemNum']}. {$item['Content']}";
                        } else {
                            $surveyQ['answer'][$item['ParentEventItemManageIdx']][$item['ItemNum']] = $item['Content'];
                        }
                    }

                    # 설문응답 조회
                    $sql = "SELECT
                                EventItemManageIdx, DataContent
                            FROM phi.UserEventData
                           WHERE (MemberManageIdx, OrderIdx) = ({$memberManageIdx}, {$orderIdx})
                             AND ItemCategory = 'survey'";
                    $stmt = $this->conn->query($sql);
                    $surveyA = [];
                    while($item = $stmt->fetch()) {
                        $surveyA[$item['EventItemManageIdx']] = $item['DataContent'];
                    }

                    if (empty($surveyQ) || empty($surveyA)) {
                        throw new \Exception('설문 데이터를 찾을 수 없습니다.', '404');
                    }

                    $userData['surveyQuestion'] = $surveyQ;
                    $userData['surveyData'] = $surveyA;

                    break;
                default:
                    break;
            }
            $this->conn = null;

            return $userData;

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // PHI 리포트 다운로드
    function getPhiReport($param): void
    {
        try {
            if (!isset($param['orderIdx'], $param['uuid'])) {
                throw new \Exception("필수 파라미터가 존재하지 않습니다.", "404");
            }

            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $sql = "SELECT
                        prm.MemberManageIdx, prm.OrderIdx, prm.ReportType, prm.`Uuid`,
                        m.Name
                    FROM phi.PhiReportManage prm
                    JOIN phi.MemberManage mm
                      ON mm.MemberManageIdx = prm.MemberManageIdx
                    JOIN phi.Member m
                      ON m.MemberIdx = mm.MemberIdx
                   WHERE prm.OrderIdx = :orderIdx
                     AND prm.`Uuid` = :uuid
                ORDER BY prm.NhisPreviewListIdx DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':orderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':uuid', $param['uuid']);
            $stmt->execute();
            $resqData = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];
            if (!$resqData) {
                throw new \Exception("PHI 데이터가 조회되지 않습니다.", "404");
            }

            $token = $this->createMedtekToken();
            if (!$token) {
                throw new \Exception('u2 request error', '401');
            }

            $requestParam = [
                'uuid' => $resqData['Uuid'],
                'phiType' => $resqData['ReportType'],
                'filename' => "{$resqData['MemberManageIdx']}_{$resqData['OrderIdx']}_{$resqData['ReportType']}",
                'u2Token' => $token
            ];

            $filename = "{$requestParam['filename']}.pdf";
            $dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
            array_pop($dir);
            array_pop($dir);
            $dir = implode('/', $dir);
            $pdfPath = "{$dir}/image/datashare/priv/u2medtek/{$filename}";
            if (!file_exists($pdfPath)) {
                $this->getU2Pdf($requestParam);
            }

            $pdfFile = file_get_contents($pdfPath, FILE_USE_INCLUDE_PATH);

            $downloadName = "{$resqData['MemberManageIdx']}_{$resqData['Name']}";
            $downloadName .= $resqData['ReportType'] == '1' ? "_생체나이결과지.pdf" : ($resqData['ReportType'] == '2' ? "_질병예측결과지.pdf" : ".pdf");

            header('Cache-Control: no-cache,no-store,max-age=0,must-revalidate');
            header('Content-Disposition: attachment; filename="' . $downloadName . '"');
            header('Content-Length: ' . strlen($pdfFile));
            header('Content-type: application/pdf;charset=UTF-8');
            header('Expires: 0');

            $this->conn = null;
            echo $pdfFile;
            exit;

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 유투메디텍 결과지 다운로드
    function getU2Pdf($param): void
    {
        try {
            //$type = 1 - 생체나이; 2 - 질병예측
            $variant = $param['phiType'] == '2' ? '1' : '0';

            $url = "{$this->apiUrlU2}/api/open/age/{$param['uuid']}/pdf";
            $header = ["Authorization: {$param['u2Token']}"];
            $body = [
                'uuid' => $param['uuid'],
                'variant' => $variant,
                'filename' => $param['filename'],
            ];

            $result = $this->curl('GET', $url, $header, $body);
            if ($result['code'] != '200') {
                throw new \Exception("PHI pdf 파일 통신 실패", "500");
            }
            $filename = "{$param['filename']}.pdf";
            $dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
            array_pop($dir);
            array_pop($dir);
            $dir = implode('/', $dir);
            $pdfPath = "{$dir}/image/datashare/priv/u2medtek/{$filename}";
            file_put_contents($pdfPath, $result['response']);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 유투메드텍 토큰 생성
    private function createMedtekToken(): string
    {
        try {
            $response = [];
            $url = "{$this->apiUrlU2}/api/open/auth";
            $apiIdU2 = "genocorebs";
            $apiSecretU2 = "genocorebs9572!";
            $data = [
                'id' => $apiIdU2,
                'password' => $apiSecretU2
            ];
            $header = [
                'Content-Type: application/json; charset=utf-8'
            ];

            $tokenData = $this->curl('POST', $url, $header, json_encode($data));
            $response = json_decode($tokenData['response'], true)['token'];
        } catch (\Exception $e) {
            $this->code = $e->getCode();
            $this->msg = $e->getMessage();
        } finally {
            return $response;
        }
    }

    // curl
    public function curl($method, $url, $header, $body)
    {
        try {
            $curl = curl_init();
            if ($method == 'POST') {
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 60,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $body,
                    CURLOPT_HTTPHEADER => $header,
                ]);

                $response = curl_exec($curl);
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
            }

            if ($method == 'GET') {
                $body = !$body ? $body : http_build_query($body, '', '&');
                $url = "{$url}?{$body}";

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($curl);
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
            }
            $return = [
                'response' => $response,
                'code' => $http_code
            ];
        } catch (\Exception $e) {
            $return['response'] = $e->getMessage();
            $return['code'] = $e->getCode();
        } finally {
            return $return;
        }
    }

    // 질병예측검사 조회
    function diseaseList($param): array
    {
        $this->desc = "model::diseaseList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }
            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['prm.RegDatetime', 'm.Name'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, prm.NhisPreviewListIdx DESC ";

            } else {
                $orderSql .= ' prm.RegDatetime DESC, prm.NhisPreviewListIdx DESC ';
            }

            $data = [];
            // 대상 전체 카운트
            $sql = "SELECT
                       prm.RegDatetime, prm.MemberManageIdx, prm.OrderIdx,
                       prm.NhisPreviewListIdx, prm.Uuid, m.Name, tm.MemberIdx AS TestMember
                    FROM phi.PhiReportManage AS prm
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = prm.MemberManageIdx
                    JOIN order.Order AS o
                      ON o.OrderIdx = prm.OrderIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
                   WHERE mm.IsOut = b'0'
                     AND o.ProductGroupIdx = :productGroupIdx
                     AND o.IsActive = b'1'
                     {$addSql}
                   GROUP BY o.OrderIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $data["idx{$item['OrderIdx']}"] = [
                    'MemberManageIdx' => $item['MemberManageIdx'],
                    'OrderIdx' => $item['OrderIdx'],
                    'Name' => $item['Name'],
                    'NhisPreviewListIdx' => $item['NhisPreviewListIdx'],
                    'Uuid' => $item['Uuid'],
                    'TestMember' => $item['TestMember'],
                    'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                ];
            }
            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 질병예측검사 리스트
    function bioageList($param): array
    {
        $this->desc = 'model::bioageList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['m.Name', 'm.Phone', 'prm.CalcDate', 'ccm.ClientCustomerName', 'pccm.ClientCustomerName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                $orderSql .= " {$param['column']} {$param['sort']}, prm.NhisPreviewListIdx DESC ";
            } else {
                $orderSql .= ' prm.RegDatetime DESC, prm.NhisPreviewListIdx DESC ';
            }

            $data = [];
            // 대상 전체 카운트
            $sql = "SELECT
                       prm.CalcDate, prm.MemberManageIdx, prm.OrderIdx, prm.Data,
                       prm.NhisPreviewListIdx, prm.Uuid, m.Name, tm.MemberIdx AS TestMember,
                       ccm.ClientCustomerName,
                       ccm.CCTel, pccm.ClientCustomerName AS ParentClientCustomerName, ccm.ClientCustomerCode, m.Phone
                    FROM phi.PhiReportManage AS prm
                    JOIN phi.MemberManage AS mm
                      ON mm.MemberManageIdx = prm.MemberManageIdx
                    JOIN order.Order AS o
                      ON o.OrderIdx = prm.OrderIdx
                    JOIN phi.Member AS m
                      ON m.MemberIdx = mm.MemberIdx
                    JOIN phi.ClientCustomerManage AS ccm
   	                  ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
               LEFT JOIN phi.ClientCustomerManage as pccm
                      ON ccm.ParentClientCustomerIdx = pccm.ClientCustomerManageIdx
               LEFT JOIN phi.TestMember AS tm
                      ON tm.MemberIdx = m.MemberIdx
                   WHERE mm.IsOut = b'0'
                     AND o.ProductGroupIdx = :productGroupIdx
                     AND o.IsActive = b'1'
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);


            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                if (isset($data[$item['OrderIdx']])) {
                    continue;
                }
                $data["idx{$item['OrderIdx']}"] = [
                    'MemberManageIdx' => $item['MemberManageIdx'],
                    'ClientCustomerCode' => $item['ClientCustomerCode'],
                    'ClientCustomerName' => $item['ClientCustomerName'],
                    'OrderIdx' => $item['OrderIdx'],
                    'Name' => $item['Name'],
                    'NhisPreviewListIdx' => $item['NhisPreviewListIdx'],
                    'Uuid' => $item['Uuid'],
                    'TestMember' => $item['TestMember'],
                    'CalcDate' => $item['CalcDate'],
                    'ParentClientCustomerName' => $item['ParentClientCustomerName'],
                    'CCTel' => $item['CCTel'],
                    'Phone' => $item['Phone'],
                    'PhiReportUrl' => "{$this->phiReportUrl}&reg=" . $this->Encrypt("{$item['MemberManageIdx']}/{$item['OrderIdx']}"),
                    'CWCnt' => 0,
                    'DHCnt' => 0,
                ];

                $phiData = json_decode($item['Data'], true);
                foreach ($phiData as $val) {
                    $stat = $this->bioMarkerGradeCovert($val['rrisk']);
                    if ($stat === '양호') {
                        continue;
                    }
                    if (in_array($stat, ['주의', '경고'])) {
                        $data["idx{$item['OrderIdx']}"]['CWCnt']++;
                    }
                    if (in_array($stat, ['위험', '고위험'])) {
                        $data["idx{$item['OrderIdx']}"]['DHCnt']++;
                    }
                }
            }

            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 무료 잔량 수정
    function updateFreeTicket($param) : array
    {
        $this->desc = 'updateFreeTicket';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $clientCustomerManageIdx = isset($param['clientCustomerManageIdx']) ? (int)$param['clientCustomerManageIdx'] : '';
            $ticketManageIdx = isset($param['ticketManageIdx']) ? (int)$param['ticketManageIdx'] : '';
            $updateCount = $param['updateCount'];

            $table = "phi.TicketManage";
            if($updateCount >= 0) {
                // 티켓 meta 갱신
                if(!$ticketManageIdx) {
                    $item = [
                        'clientCustomerManageIdx' => $clientCustomerManageIdx,
                        'ticketType'              => 2,
                    ];
                    $ticketManageIdx = $this->insertUpdate([],$table, $item);
                } else {
                    $item['modDatetime'] = date('Y-m-d H:i:s');
                    $this->insertUpdate(['ticketManageIdx'=>$ticketManageIdx], $table, $item);
                }

                // 티켓 지급
                $table = "phi.IssuedTicketManage";
                $items = [];
                for($i=0;$i<$updateCount;$i++) {
                    $items[] = [
                        'ticketManageIdx' => $ticketManageIdx,
                        'clientCustomerManageIdx' => $clientCustomerManageIdx,
                    ];
                }
                $this->bulkInsertUpdate([], $table, $items);
                $this->msg = "무료지급권을 ".$updateCount."개 부여하였습니다.";
                // 지급 (insert)
            } else {
                // 삭제
                $updateCount = -($updateCount);
                if(!$ticketManageIdx) {
                    throw new \Exception("develop error","503");
                }
                $sql = "SELECT IssuedTicketManageIdx
                         FROM phi.IssuedTicketManage
                        WHERE ClientCustomerManageIdx = ".$clientCustomerManageIdx."
                          AND TicketManageIdx = ".$ticketManageIdx."
                     ORDER BY IssuedDatetime DESC
                        LIMIT ".$updateCount;
                $stmt = $this->conn->query($sql);
                $delTicket = [];
                while($row = $stmt->fetch()) {
                    $delTicket[] = $row['IssuedTicketManageIdx'];
                }
                $delTicket = count($delTicket)>1 ? implode(',', $delTicket) : $delTicket[0];

                $sql = "DELETE FROM phi.IssuedTicketManage
                              WHERE IssuedTicketManageIdx IN (".$delTicket.")
                              LIMIT ".$updateCount;
                $this->conn->query($sql);
                $this->msg = "무료지급권을 ".$updateCount."개 삭제하였습니다.";
            }
            return $this->response();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 상담사 정보 수정
    function updateClientData($param) : array
    {
        $this->desc = 'updateClientData';
        try {
            if(!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $clientCustomerManageIdx = isset($param['clientCustomerManageIdx']) ? (int)$param['clientCustomerManageIdx'] : '';
            $clientCustomerName = isset($param['clientCustomerName']) ? $param['clientCustomerName'] : '';
            $cCGroup = $param['cCGroup'] !== '' ? $param['cCGroup'] : 'null';
            $cCTel = isset($param['cCTel']) ? $param['cCTel'] : '';
            $item = [
                'clientCustomerName' => $clientCustomerName,
                'cCManager'          => $clientCustomerName,
                'cCGroup'            => $cCGroup,
                'cCTel'              => $cCTel,
            ];
            $table = "phi.ClientCustomerManage";
            $item['modDatetime'] = date('Y-m-d H:i:s');
            $this->insertUpdate(['clientCustomerManageIdx'=>$clientCustomerManageIdx], $table, $item);
            $this->msg = "상담사 정보를 수정하였습니다.";
            return $this->response();
        } catch (\Exception $e) {
            throw $e;
        }
    }


    // 사용자 정보 대량 등록
    function uploadOfferCompanyDb($param): array
    {
        $this->desc = 'uploadOfferCompanyDb';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['gIdx'], $param['category'], $param[0]['companyFile'])) {
                throw new \Exception("필수 파라미터가 없습니다.", "404");
            }

            $sql = "SELECT ClientCustomerManageIdx, ClientCustomerName, ServiceCompanyManageIdx
                      FROM phi.ClientCustomerManage
                     WHERE ProductGroupIdx = :productGroupIdx
                      AND IsUse = b'1'
                      AND `Depth` = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetchAll($this->conn::FETCH_ASSOC);
            if (count($row) === 0) {
                throw new \Exception('등록된 보험사가 존재하지않습니다.', 400);
            }
            $parentClientCustomer = [];
            foreach ($row as $data) {
                $parentClientCustomer[$data['ClientCustomerName']] = [
                    'serviceIdx' => $data['ServiceCompanyManageIdx'],
                    'clientIdx' => $data['ClientCustomerManageIdx'],
                ];
            }

            $serverFilename = $param[0]['companyFile']['tmp_name'];
            $pcFilename = $param[0]['companyFile']['name'];

            $spreadsheet = new SpreadsheetFactory();
            $result = $spreadsheet->readSheet($serverFilename, $pcFilename);
            if ($result['code'] !== 200) {
                throw new \Exception('read error', 400);
            }

            $spreadData = $result['data'];
            if (count($spreadData) < 1) {
                throw new \Exception("양식이 입력되지 않았습니다." , "401");
            }
            unset($spreadData[0]);
            unset($spreadData[1]);
            unset($spreadData[2]);

            foreach ($spreadData as $key => $value) {
                if (!array_filter($value)) {
                    continue;
                }
                if (!isset($parentClientCustomer[$value[0]])) {
                    throw new \Exception("사용처명이 올바르지않거나, 등록되지않은 사용처입니다." , "401");
                }
                if (!$value[2]) {
                    throw new \Exception("상담사명 입력은 필수입니다." , "401");
                }
                if (!$value[3] || !preg_match($this->pattern['num'], $value[3])) {
                    throw new \Exception("전화번호 입력은 필수입니다." , "401");
                }

                $clientCustomerCode = $this->generateClientCode((int)$parentClientCustomer[$value[0]]['serviceIdx']);
                $table = "phi.ClientCustomerManage";
                $item = [
                    'parentClientCustomerIdx' => (int)$parentClientCustomer[$value[0]]['clientIdx'],
                    'serviceCompanyManageIdx' => (int)$parentClientCustomer[$value[0]]['serviceIdx'],
                    'category' => (string)$param['category'],
                    'clientCustomerCode' => $clientCustomerCode,
                    'clientCustomerName' => (string)$value[2],
                    'cCGroup' => (string)$value[1],
                    'cCManager' => (string)$value[2],
                    'cCTel' => (string)$value[3],
                    'productGroupIdx' => (int)$param['gIdx'],
                    'isUse' => 1,
                    'isActive' => 1,
                    'depth' => 2,
                    'latestAdminIP' => $_SERVER['REMOTE_ADDR'],
                ];

                $clientCustomerManageIdx = $this->insertUpdate([], $table, $item);

                $serveCount = (int)$value['4'];
                if($serveCount > 0) {

                    $table = "phi.TicketManage";
                    $item = [
                        'ticketType' => 2,
                        'clientCustomerManageIdx' => $clientCustomerManageIdx,
                    ];
                    $sql = "SELECT TicketManageIdx FROM phi.TicketManage
                                 WHERE ClientCustomerManageIdx = ".$clientCustomerManageIdx. " AND TicketType = 2";
                    $stmt = $this->conn->query($sql);
                    $ticketIdx = $stmt->fetch();

                    // 티켓 meta 갱신
                    if(!$ticketIdx) {
                        $ticketIdx = $this->insertUpdate([],$table, $item);
                    } else {
                        $ticketIdx = (int)$ticketIdx['TicketManageIdx'];
                        $item['modDatetime'] = date('Y-m-d H:i:s');
                        $this->insertUpdate(['ticketManageIdx'=>$ticketIdx], $table, $item);
                    }

                    // 티켓 지급
                    $table = "phi.IssuedTicketManage";
                    $items = [];
                    for($i=0;$i<$serveCount;$i++) {
                        $items[] = [
                            'ticketManageIdx' => $ticketIdx,
                            'clientCustomerManageIdx' => $clientCustomerManageIdx,
                        ];
                    }
                    $this->bulkInsertUpdate([], $table, $items);
                }
            }
            $this->msg = "상담사 정보 대량등록이 완료되었습니다.";
            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //사용처 대량등록
    function uploadCompanyDb($param): array
    {
        $this->desc = 'uploadCompanyDb';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param['parentClientCustomerIdx'], $param[0]['companyFile'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            $serverFilename = $param[0]['companyFile']['tmp_name'];
            $pcFilename = $param[0]['companyFile']['name'];

            $spreadsheet = new SpreadsheetFactory();
            $result = $spreadsheet->readSheet($serverFilename, $pcFilename);
            if ($result['code'] !== 200) {
                throw new \Exception('read error', "400");
            }

            $spreadData = $result['data'];
            if (count($spreadData) < 1) {
                throw new \Exception("양식이 입력되지 않았습니다." , "401");
            }
            unset($spreadData[0]);
            $items = [];
            foreach ($spreadData as $value) {
                if (!array_filter($value)) {
                    continue;
                }
                if (!$value[1]) {
                    throw new \Exception("거래처 코드 입력은 필수입니다." , "401");
                }
                if (
                    !in_array($value[0], ['H', 'P', 'I'])
                    || !preg_match($this->pattern['code'], $value[1])
                    || !preg_match($this->pattern['all'], $value[2])
                    || ($value[3] && !preg_match($this->pattern['kor'], $value[3]))
                    || ($value[4] && !preg_match($this->pattern['num'], $value[4]))
                    || ($value[5] && !preg_match($this->pattern['num'], $value[5]))
                    || ($value[6] && !preg_match($this->pattern['kor'], $value[6]))
                    || ($value[7] && !preg_match($this->pattern['kor'], $value[7]))
                    || ($value[8] && !preg_match($this->pattern['kor'], $value[8]))
                    || ($value[9] && !preg_match($this->pattern['all'], $value[9]))
                    || ($value[10] && !in_array($value[10], [1, 2]))
                    || ($value[11] && !in_array($value[11], ['blood', 'buccal', 'none']))
                ) {
                    throw new \Exception('필수 파라미터가 올바르지 않습니다.', '400');
                }

                $sql = "SELECT ServiceCompanyManageIdx FROM phi.ClientCustomerManage WHERE ClientCustomerManageIdx=".$param['parentClientCustomerIdx'];
                $stmt =  $this->conn->query($sql);
                $row = $stmt->fetch();
                if(!$row) {
                    throw new \Exception("등록 데이터가 올바르지 않습니다.",'504');
                }
                $serviceCompanyManageIdx = (int)$row['ServiceCompanyManageIdx'];

                $items[] = [
                    'serviceCompanyManageIdx' => $serviceCompanyManageIdx ?? '',
                    'parentClientCustomerIdx' => (int)$param['parentClientCustomerIdx'],
                    'category' => (string)$value[0],
                    'clientCustomerCode' => (string)$value[1],
                    'clientCustomerName' => (string)$value[2],
                    'cCManager' => (string)$value[3],
                    'cCTel' => (string)$value[4],
                    'postCode' => (string)$value[5],
                    'state' => (string)$value[6],
                    'city' => (string)$value[7],
                    'fullCity' => (string)$value[8],
                    'addressDetail' => htmlspecialchars($value[9]),
                    'responseType' => (int)$value[10],
                    'specimenType' => (string)$value[11],
                    'productGroupIdx' => (int)$value[12] ?? NULL,
                    'depth' => 2,
                ];
            }
            $table = "phi.ClientCustomerManage";
            $this->bulkInsertUpdate([], $table, $items);

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }


    //QR코드 다운
    function qrDown($param): void
    {
        $this->desc = 'qrDown';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            if (!isset($param['clientCustomerManageIdx'])) {
                throw new \Exception("필수 파라미터가 없습니다.", "404");
            }
            $clientCustomerManageIdx = (int)$param['clientCustomerManageIdx'];
            $sql = "SELECT
                        CCM.QRurl, CCM.ClientCustomerCode, CCM.ClientCustomerName, CCM.ProductGroupIdx
                      FROM phi.ClientCustomerManage CCM
                      JOIN phi.ProductGroup PG
                        ON PG.ProductGroupIdx = CCM.ProductGroupIdx
                     WHERE CCM.ClientCustomerManageIdx = :clientCustomerManageIdx
                       AND PG.BusinessManageIdx = 1 AND PG.IsUse = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':clientCustomerManageIdx', $clientCustomerManageIdx, $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch($this->conn::FETCH_ASSOC);

            if (!is_array($row)) {
                throw new \Exception("등록된 상품그룹 정보가 없습니다.", "400");
            }
            if (!$row['ClientCustomerCode']) {
                throw new \Exception("병원코드가 등록되지 않았습니다.", "400");
            }
            $clientCustomerName = $row['ClientCustomerName'];
            if (!$row['QRurl']) {
                $orgUrl = "https://ds.genocorebs.com/phi/?hCode=" . $row['ClientCustomerCode'];
                $result = (new NaverShortUrl())->getResult(['url' => $orgUrl]);
                if ($result['code'] !== 200) {
                    throw new \Exception("URL 생성에 실패하였습니다.", "400");
                }
                $response = json_decode($result['response'], true);
                $shortUrl = $response['result']['url'];
                if (!$shortUrl) {
                    throw new \Exception("URL 생성에 실패하였습니다.", 400);
                }

                $idx = ['clientCustomerManageIdx' => $clientCustomerManageIdx];
                $item = ['qRurl' => "{$shortUrl}.qr"];
                $table = "phi.ClientCustomerManage";
                $this->insertUpdate($idx, $table, $item);

                $row['QRurl'] = "{$shortUrl}.qr";
            }
            list($width, $height) = getimagesize($row['QRurl']);

            $newWidth = $width * 5;
            $newHeight = $height * 5;
            $thumb = imagecreatetruecolor($newWidth, $newHeight);

            $white = imagecolorallocate($thumb, 0, 0, 0);
            $dir = explode('/', $_SERVER['DOCUMENT_ROOT']);
            array_pop($dir);
            array_pop($dir);
            $dir = implode('/', $dir);
            $font = "{$dir}/image/NanumGothic.ttf";

            $bbox = imagettfbbox(18, 0, $font, $clientCustomerName);
            $center = (imagesx($thumb) / 2) - (($bbox[2] - $bbox[0]) / 2);

            $qrImage = imagecreatefrompng($row['QRurl']);
            $resizedQrImage = imagecopyresized($thumb, $qrImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            $qrImageWithText = imagettftext($thumb, 18, 0, $center, 390, $white, $font, $clientCustomerName);
            $finalImage = imagecrop($thumb, ['x' => 3 * 5, 'y' => 3 * 5, 'width' => 78 * 5, 'height' => 78 * 5]);

            $filename = "{$clientCustomerName} QrCode.png";

            header("Pragma: public");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header('Content-Disposition: attachment; filename="' . $filename . '"; filename*=utf-8\' \'' . rawurlencode($filename));
            header("Content-Transfer-Encoding: binary");

            imagepng($finalImage);
            imagedestroy($finalImage);

            exit;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @brief 단일 충돌 등록,수정
     * @param array $unique : UniqueKey, array $table : table, array $items : [column=>value,..], $addUpdate = "
     *     ModDatetime = yyyy-mm-dd.."
     * @return int : lastInsertId, INSERT=>idx, UPDATE=>0
     * @throws \Exception
     * @author hellostellaa
     */
    function insertDuplicate(array $unique, string $table, array $item, string $addUpdate): int
    {
        $this->desc = 'model::insertDuplicate';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $updateValues = '';
            if (count($unique) > 0) {
                foreach ($unique as $key => $value) {
                    if ($value === '') {
                        unset($unique[$key]);
                    } else {
                        if ($updateValues !== '') {
                            $updateValues .= ",";
                        }
                        $column = (gettype($value) === 'integer' || $key === 'isUse' || $key === 'isActive') ? $value : "'{$value}'";
                        $updateValues .= ucfirst($key) . " = " . $column;
                    }
                }
            }
            if ($addUpdate) {
                $updateValues .= ", {$addUpdate}";
            }

            $insertColumns = '';
            $insertValues = '';
            if (count($item) > 0) {
                foreach ($item as $key => $value) {
                    if ($value === '') {
                        unset($item[$key]);
                    } else {
                        if ($insertColumns !== "") {
                            $insertColumns .= ",";
                            $insertValues .= ",";
                        }
                        $insertColumns .= ucfirst($key);
                        $column = (gettype($value) === 'integer' || $key === 'isUse' || $key === 'isActive') ? $value : "'{$value}'";
                        $insertValues .= $column;
                    }
                }
            }
            if (!$table || !$insertColumns || !$insertValues) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }

            $sql = "INSERT INTO {$table} ({$insertColumns}) VALUES ({$insertValues})
                    ON DUPLICATE KEY UPDATE {$updateValues}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $this->conn->lastInsertId();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @brief 단일 등록,수정
     * @param array $idx : PrimaryKey or UniqueKey, string $table : table, array $item : [column=>value,..]
     * @return int : lastInsertId, INSERT=>idx, UPDATE=>0
     * @throws \Exception
     * @author hellostellaa
     */
    function insertUpdate(array $idx, string $table, array $item): int
    {
        $this->desc = 'model::insertUpdate';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (count($idx) > 0) {
                // 갱신
                $whereQuery = "";
                foreach ($idx as $key => $value) {
                    if ($whereQuery !== "") {
                        $whereQuery .= " AND ";
                    }
                    $column = (gettype($value) === 'integer' || $key === 'isUse' || $key === 'isActive') ? $value : "'{$value}'";
                    $whereQuery .= ucfirst($key) . " = " . $column;
                }

                $updateQuery = "";
                if (count($item) > 0) {
                    foreach ($item as $key => $value) {
                        if ($value === '') {
                            unset($item[$key]);
                        } else if($value === 'null') {
                            if ($updateQuery !== "") {
                                $updateQuery .= ",";
                            }
                            $updateQuery .= ucfirst($key) . " = NULL";
                        } else {
                            if ($updateQuery !== "") {
                                $updateQuery .= ",";
                            }
                            $column = (gettype($value) === 'integer' || $key === 'isUse' || $key === 'isActive') ? $value : "'{$value}'";
                            $updateQuery .= ucfirst($key) . " = " . $column;

                        }
                    }
                }

                if (!$table || !$updateQuery || !$whereQuery) {
                    throw new \Exception('필수 파라미터가 없습니다.', '404');
                }

                $sql = "UPDATE {$table}
                        SET {$updateQuery}
                        WHERE {$whereQuery}";

            } else {
                // 등록
                $insertColumns = "";
                $insertValues = "";
                if (count($item) > 0) {
                    foreach ($item as $key => $value) {
                        if ($value === '') {
                            unset($item[$key]);
                        } else if($value === 'null') {
                            if ($insertColumns !== "") {
                                $insertColumns .= ",";
                                $insertValues .= ",";
                            }
                            $insertColumns .= ucfirst($key);
                            $insertValues .= "NULL";
                        } else {
                            if ($insertColumns !== "") {
                                $insertColumns .= ",";
                                $insertValues .= ",";
                            }
                            $insertColumns .= ucfirst($key);
                            $column = (gettype($value) === 'integer' || $key === 'isUse' || $key === 'isActive') ? $value : "'{$value}'";
                            $insertValues .= $column;
                        }
                    }
                }
                if (!$table || !$insertColumns || !$insertValues) {
                    throw new \Exception('필수 파라미터가 없습니다.', '404');
                }
                $sql = "INSERT INTO {$table} ({$insertColumns}) VALUES ({$insertValues})";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $this->conn->lastInsertId();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @brief 복수 등록,수정
     * @param array $idx : PrimaryKey or UniqueKey, string $table : table, array $items : [column=>value,..]
     * @return int : lastInsertId, INSERT=>idx, UPDATE=>0
     * @throws \Exception
     * @author hellostellaa
     */
    function bulkInsertUpdate(array $idx, string $table, array $items): int
    {
        $this->desc = 'model::bulkInsertUpdate';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (count($idx) > 0) {
                $whereQuery = "";
                foreach ($idx as $key => $value) {
                    if ($whereQuery !== "") {
                        $whereQuery .= " AND ";
                    }

                    $whereQuery .= ucfirst($key) . " IN ({$value})";
                }
                $updateQuery = "";
                if (count($items) > 0) {
                    foreach ($items as $key => $value) {
                        if ($value === '') {
                            unset($items[$key]);
                        } else {
                            if ($updateQuery !== "") {
                                $updateQuery .= ",";
                            }
                            $column = (gettype($value) === 'integer' || $key === 'isUse' || $key === 'isActive') ? $value : "'{$value}'";
                            $updateQuery .= ucfirst($key) . " = " . $column;
                        }
                    }
                }
                if (!$table || !$updateQuery || !$whereQuery) {
                    throw new \Exception('필수 파라미터가 없습니다.', '404');
                }
                $sql = "UPDATE {$table}
                        SET {$updateQuery}
                        WHERE {$whereQuery}";
            } else {
                // 등록
                // 컬럼의 데이터타입 확인
                $types = [];
                foreach ($items[0] as $item) {
                    $types[] = gettype($item);
                }
                // 입력 컬럼, 입력 값 배열 정의
                $insertColumns = "";
                $insertVal = [];
                if (count($items) > 0) {
                    foreach ($items as $key => $value) {
                        if ($key === 0) {
                            $columns = array_keys($value);
                            foreach ($columns as $k => $col) {
                                if ($k > 0) {
                                    $insertColumns .= ",";
                                }
                                $insertColumns .= ucfirst($col);
                            }
                        }
                        $insertVal[] = array_values($value);
                    }
                }
                // 입력 값 배열 내 데이터 타입 확인 및 교정
                $_D = [];
                $_d = [];
                foreach ($insertVal as $keys => $values) {
                    foreach ($values as $key => $value) {
                        if (!$value) {
                            $_d[$keys][] = "NULL";
                            continue;
                        }
                        if ($types[$key] === 'string') {
                            $_d[$keys][] = "'{$value}'";
                        } else {
                            $_d[$keys][] = $value;
                        }
                    }
                    $_D[] = "(" . implode(',', $_d[$keys]) . ")";
                }
                $insertValues = implode(',', $_D);
                // sql
                if (!$table || !$insertColumns || !$insertValues) {
                    throw new \Exception('필수 파라미터가 없습니다.', '404');
                }
                $sql = "INSERT INTO {$table} ({$insertColumns}) VALUES {$insertValues}";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $this->conn->lastInsertId();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    //사용처 등록:수정
    function registCompany($param): array
    {
        $this->desc = 'model::registCompany';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['parentClientCustomerIdx'], $param['category'], $param['companyCode'], $param['companyName'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            if (
                !in_array($param['category'], ['H', 'P', 'I'])
                || !preg_match($this->pattern['code'], $param['companyCode'])
                || !preg_match($this->pattern['all'], $param['companyName'])
                || (isset($param['manager']) && !preg_match($this->pattern['kor'], $param['manager']))
                || (isset($param['phone']) && !preg_match($this->pattern['num'], $param['phone']))
                || (isset($param['mainTel']) && !preg_match($this->pattern['num'], $param['mainTel']))
                || (isset($param['postcode']) && !preg_match($this->pattern['num'], $param['postcode']))
                || (isset($param['sido']) && !preg_match($this->pattern['kor'], $param['sido']))
                || (isset($param['sigungu']) && !preg_match($this->pattern['kor'], $param['sigungu']))
                || (isset($param['roadname']) && !preg_match($this->pattern['kor'], $param['roadname']))
                || (isset($param['addressDetail']) && !preg_match($this->pattern['all'], $param['addressDetail']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', '400');
            }
            $idx = isset($param['clientCustomerManageIdx']) ? ['clientCustomerManageIdx' => (int)$param['clientCustomerManageIdx']] : [];

            if (isset($param['mainTel'])) {
                $sql = "SELECT CCMainTel FROM phi.ClientCustomerContractManage WHERE ClientCustomerManageIdx = ".$param['clientCustomerManageIdx'];
                $stmt = $this->conn->query($sql);
                $row = $stmt->fetch();
                if (!$row) {
                    throw new \Exception("등록 데이터가 올바르지 않습니다.", '504');
                }
                $table = "phi.ClientCustomerContractManage";
                $item = [
                    'cCMainTel' => (string)$param['mainTel'],
                ];
                $this->insertUpdate($idx, $table, $item);
            }

            $table = "phi.ClientCustomerManage";

            $sql = "SELECT ServiceCompanyManageIdx FROM phi.ClientCustomerManage WHERE ClientCustomerManageIdx=".$param['parentClientCustomerIdx'];
            $stmt =  $this->conn->query($sql);
            $row = $stmt->fetch();
            if(!$row) {
                throw new \Exception("등록 데이터가 올바르지 않습니다.",'504');
            }
            $serviceCompanyManageIdx = (int)$row['ServiceCompanyManageIdx'];

            $parentClientCustomerIdx = (int)$param['parentClientCustomerIdx'];
            $category = $param['category'];
            $depth = isset($param['depth']) ? (int)$param['depth'] : 2;
            $clientCustomerCode = $param['companyCode'];
            $sql = "SELECT COUNT(*) AS CodeCnt FROM phi.ClientCustomerManage
                    WHERE ClientCustomerCode = :clientCustomerCode";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':clientCustomerCode', $clientCustomerCode);
            $stmt->execute();
            $codeCnt = $stmt->fetch()['CodeCnt'] ?? 0;
            if ($codeCnt > 0 && !isset($param['clientCustomerManageIdx'])) {
                $clientCustomerCode = "{$clientCustomerCode}_{$codeCnt}";
            }

            $clientCustomerName = $param['companyName'];
            $cCManager = isset($param['manager']) ? (string)$param['manager'] : '';
            $cCTel = isset($param['phone']) ? (string)$param['phone'] : '';
            $postCode = isset($param['postcode']) ? (string)$param['postcode'] : '';
            $state = isset($param['sido']) ? (string)$param['sido'] : '';
            $city = isset($param['sigungu']) ? (string)$param['sigungu'] : '';
            $fullCity = isset($param['roadname']) ? (string)$param['roadname'] : '';
            $addressDetail = isset($param['addressDetail']) ? (string)$param['addressDetail'] : '';
            $productGroup = isset($param['productGroup']) ? (int)$param['productGroup'] : '';
            $isUse = isset($param['isUse']) ? $param['isUse'] : b'1';
            $isActive = isset($param['isActive']) ? $param['isActive'] : b'1';

            $item = [
                'serviceCompanyManageIdx' => $serviceCompanyManageIdx ?? '',
                'parentClientCustomerIdx' => $parentClientCustomerIdx ?? '',
                'category' => $category,
                'depth' => $depth,
                'clientCustomerCode' => $clientCustomerCode,
                'clientCustomerName' => $clientCustomerName,
                'cCManager' => $cCManager,
                'cCTel' => $cCTel,
                'postCode' => $postCode,
                'state' => $state,
                'city' => $city,
                'fullCity' => $fullCity,
                'addressDetail' => $addressDetail,
                'productGroupIdx' => $productGroup,
                'latestAdminIP' => $_SERVER['REMOTE_ADDR'],
                'modDatetime' => date('Y-m-d H:i:s'),
                'isUse' => $isUse,
                'isActive' => $isActive
            ];
            $this->insertUpdate($idx, $table, $item);

            $this->conn = null;
            return $this->response();// 등록
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //사용처 조회 (식별자 기준)
    function searchCompany($param): array
    {
        $this->desc = 'model::searchCompany';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['clientCustomerManageIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            $sql = "SELECT
                      ccm.ClientCustomerManageIdx, ccm.ProductGroupIdx, ccm.ClientCustomerCode, ccm.ClientCustomerName
                    , ccm.ParentClientCustomerIdx, ccm.Depth, ccm.Category, ccm.State, ccm.City, ccm.FullCity, ccm.AddressDetail
                    , ccm.PostCode, ccm.CCTel, ccm.CCManager, ccm.QRurl, ccm.RegDatetime
                    , pg.ProductGroupName, pg.ProductGroupCode
                    , ccm2.ClientCustomerName AS ParentClientCustomerName
                    , ccm.ModDatetime, ccm.IsUse
                    , cccm.CCMainTel, cccm.ContractDocId
                    FROM phi.ClientCustomerManage AS ccm
                    JOIN phi.ClientCustomerManage AS ccm2
                    ON ccm2.ClientCustomerManageIdx = ccm.ParentClientCustomerIdx
                    LEFT JOIN phi.ClientCustomerContractManage AS cccm
                    ON cccm.ClientCustomerManageIdx = ccm.ClientCustomerManageIdx
                    LEFT JOIN phi.ProductGroup AS pg
                    ON pg.ProductGroupIdx = ccm.ProductGroupIdx
                    WHERE ccm.ClientCustomerManageIdx = :clientCustomerManageIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':clientCustomerManageIdx', $param['clientCustomerManageIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch() ?? '';
            if (!$row) {
                throw new \Exception("필수 파라미터가 올바르지 않습니다.", "400");
            }
            $this->data = [
                'ClientCustomerManageIdx' => $row['ClientCustomerManageIdx'] ?? '',
                'ProductGroupIdx' => $row['ProductGroupIdx'] ?? '',
                'ClientCustomerCode' => $row['ClientCustomerCode'] ?? '',
                'ClientCustomerName' => $row['ClientCustomerName'] ?? '',
                'ParentClientCustomerIdx' => $row['ParentClientCustomerIdx'] ?? '',
                'Depth' => $row['Depth'] ?? '',
                'Category' => $row['Category'] ?? '',
                'State' => $row['State'] ?? '',
                'City' => $row['City'] ?? '',
                'FullCity' => $row['FullCity'] ?? '',
                'AddressDetail' => $row['AddressDetail'] ?? '',
                'PostCode' => $row['PostCode'] ?? '',
                'CCTel' => $row['CCTel'] ?? '',
                'CCManager' => $row['CCManager'] ?? '',
                'QRurl' => $row['QRurl'] ?? '',
                'RegDatetime' => substr($row['RegDatetime'], 10) ?? '',
                'ProductGroupCode' => $row['ProductGroupCode'] ?? '',
                'ParentClientCustomerName' => $row['ParentClientCustomerName'] ?? '',
                'IsUse' => $row['IsUse'] ?? '',
            ];
            if ($row['ContractDocId']) {
                $this->data['CCMainTel'] = $row['CCMainTel'];
            }

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }


    //사용처 조회 (식별자 기준)
    function searchCouponManageData($param): array
    {
        $this->desc = 'model::searchServiceCompany';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            $sql = "SELECT
                          cm.CouponManageIdx, cm.CouponType, cm.CouponCode, cm.CouponName, cm.DiscountMethod
                        , cm.DiscountAmount, cm.DiscountRate, cm.ServiceCompanyManageIdx, cm.ClientCustomerManageIdx
                        , cm.UseStartDate, cm.UseEndDate, cm.CouponStatus, cm.RegDatetime, cm.ModDatetime
                        , sm.ServiceCompanyName
                      FROM phi.CouponManage AS cm
                      JOIN phi.ServiceCompanyManage AS sm
                        ON sm.ServiceCompanyManageIdx = cm.ServiceCompanyManageIdx
                     WHERE cm.CouponManageIdx = :couponManageIdx
                       AND cm.ProductGroupIdx = :productGroupIdx
                       AND cm.IsUse = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':couponManageIdx', $param['couponManageIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            while($row = $stmt->fetch()) {
                $this->data = [
                    'couponManageIdx'         => $row['CouponManageIdx'],
                    'couponType'              => $row['CouponType'],
                    'couponCode'              => $row['CouponCode'],
                    'couponName'              => $row['CouponName'],
                    'discountMethod'          => $row['DiscountMethod'],
                    'discountAmount'          => $row['DiscountAmount'],
                    'discountRate'            => $row['DiscountRate'],
                    'serviceCompanyManageIdx' => $row['ServiceCompanyManageIdx'],
                    'serviceCompanyName'      => $row['ServiceCompanyName'],
                    'clientCustomerManageIdx' => $row['ClientCustomerManageIdx'],
                    'useStartDate'            => $row['UseStartDate'],
                    'useEndDate'              => $row['UseEndDate'],
                    'couponStatus'            => $row['CouponStatus'],
                    'clientCustomerCode'      => '',
                ];
            }

            if($this->data['clientCustomerManageIdx']) {
                $sql = "SELECT ClientCustomerCode
                          FROM phi.ClientCustomerManage
                         WHERE ClientCustomerManageIdx = ".$this->data['clientCustomerManageIdx'];
                $stmt = $this->conn->query($sql);
                $this->data['clientCustomerCode'] = $stmt->fetch()['ClientCustomerCode'];
            }

            $sql = "SELECT ServiceCompanyManageIdx AS `value`, ServiceCompanyName AS `text`
                    FROM phi.ServiceCompanyManage
                    WHERE IsContract = b'1'";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll() ?? [];
            $this->data['select::serviceCompanyManage'] = $row;

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //사용처 리스트 조회
    function companyList($param, $gIdx): array
    {
        $this->desc = 'model::companyList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if (isset($param['category']) && $param['category'] === 'I'){
                $addSql .= " AND ccm.Category = 'I'";
            }
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['ccm2.ClientCustomerName', 'ccm.ClientCustomerName', 'pg.ProductGroupName', 'ccm.CCManager'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else if (in_array($param['keyword'], ['ccm.CCTel', 'cccm.CCMainTel'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '{$param['value']}%'";
                } else {
                    if ($param['keyword'] === 'ccm.Category') {
                        if ($param['value'] === '병원') {
                            $param['value'] = 'H';
                        } else if ($param['value'] === '약국') {
                            $param['value'] = 'P';
                        }
                    }
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $orderSql = ' ORDER BY';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                switch ($param['column']) {
                    case 'Address':
                        $orderSql .= " ccm.State {$param['sort']}, ccm.City {$param['sort']}, ccm.FullCity {$param['sort']} ";
                        break;
                    default:
                        $orderSql .= " {$param['column']} {$param['sort']} ";
                }
            } else {
                $orderSql .= ' ccm.RegDatetime DESC ';
            }

            $data = [];
            $sql = "SELECT
                      ccm.ClientCustomerManageIdx, ccm.ProductGroupIdx, ccm.ClientCustomerCode, ccm.ClientCustomerName
                    , ccm.ParentClientCustomerIdx, ccm.Depth, ccm.Category, ccm.State, ccm.City, ccm.FullCity, ccm.AddressDetail
                    , ccm.PostCode, ccm.CCTel, ccm.CCManager, ccm.QRurl, ccm.RegDatetime, ccm.ResponseType, ccm.SpecimenType
                    , ccm.ModDatetime, ccm.IsUse, ccm.IsActive
                    , pg.ProductGroupName, pg.ProductGroupCode
                    , ccm2.ClientCustomerName AS ParentClientCustomerName
                    , cccm.Contents, cccm.CCMainTel
                    FROM phi.ClientCustomerManage AS ccm
                    JOIN phi.ClientCustomerManage AS ccm2
                      ON ccm2.ClientCustomerManageIdx = ccm.ParentClientCustomerIdx
                    LEFT JOIN phi.ClientCustomerContractManage as cccm
                        ON ccm.ClientCustomerManageIdx = cccm.ClientCustomerManageIdx
                    LEFT JOIN phi.ProductGroup AS pg
                      ON pg.ProductGroupIdx = ccm.ProductGroupIdx
                   WHERE ccm.Depth = 2
                     AND (ccm.ProductGroupIdx = :productGroupIdx OR ccm.ProductGroupIdx IS NULL)
                     AND (cccm.ContractStatus = 'E' OR cccm.ClientCustomerManageIdx IS NULL)
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $gIdx, $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);
            //main query
            $sql .= $orderSql;
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $gIdx, $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $data[] = [
                    'ClientCustomerManageIdx' => $row['ClientCustomerManageIdx'] ?? '',
                    'ProductGroupIdx' => $row['ProductGroupIdx'] ?? '',
                    'ClientCustomerCode' => $row['ClientCustomerCode'] ?? '',
                    'ClientCustomerName' => $row['ClientCustomerName'] ?? '',
                    'ParentClientCustomerIdx' => $row['ParentClientCustomerIdx'] ?? '',
                    'Depth' => $row['Depth'] ?? '',
                    'Category' => $row['Category'] ?? '',
                    'State' => $row['State'] ?? '',
                    'City' => $row['City'] ?? '',
                    'FullCity' => $row['FullCity'] ?? '',
                    'AddressDetail' => $row['AddressDetail'] ?? '',
                    'PostCode' => $row['PostCode'] ?? '',
                    'CCTel' => $row['CCTel'] ?? '',
                    'CCMainTel' => $row['CCMainTel'] ?? '',
                    'CCManager' => $row['CCManager'] ?? '',
                    'QRurl' => $row['QRurl'] ?? '',
                    'RegDatetime' => substr($row['RegDatetime'], 0, 10) ?? '',
                    'ProductGroupName' => $row['ProductGroupName'] ?? '',
                    'ProductGroupCode' => $row['ProductGroupCode'] ?? '',
                    'ParentClientCustomerName' => $row['ParentClientCustomerName'] ?? '',
                    'ResponseType' => $row['ResponseType'] ?? '',
                    'SpecimenType' => $row['SpecimenType'] ?? '',
                    'ModDatetime' => $row['ModDatetime'] ?? '',
                    'Contents' => $row['Contents'] ?? '',
                    'IsUse' => $row['IsUse'] ?? '',
                    'IsActive' => $row['IsActive'] ?? '',
                ];
            }
            $this->data['data'] = $data;

            // 거래처 셀렉트박스용
            $sql = "SELECT ClientCustomerManageIdx AS `value`, ClientCustomerName AS `text`
                    FROM phi.ClientCustomerManage
                    WHERE Depth = 1";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll() ?? [];
            $this->data['select::client'] = $row;
            $this->data['select::clientCustomer'] = $row;

            // 상품그룹 셀렉트박스용
            $sql = "SELECT ProductGroupIdx AS `value`, ProductGroupName AS `text`
                    FROM phi.ProductGroup
                    WHERE IsUse = b'1'";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll() ?? [];
            $this->data['select::productGroup'] = $row;

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 상품그룹 정보 세팅
    function setGroupInfo($groupCode): array
    {
        $this->desc = 'model::setGroupInfo';
        try {
            $this->conn = DB::connection()->getPdo();
            $sql = "SELECT ProductGroupCode, ProductGroupIdx, ProductGroupName
                    FROM phi.ProductGroup
                    WHERE IsUse = b'1'
                    ORDER BY ProductGroupIdx DESC";
            $stmt = $this->conn->query($sql);
            while ($row = $stmt->fetch()) {
                if ($row['ProductGroupCode'] === $groupCode) {
                    $this->data['ProductGroupIdx'] = $row['ProductGroupIdx'];
                    $this->data['ProductGroupCode'] = $groupCode;
                } else {
                    $this->data['ProductGroupIdx'] = 6;
                    $this->data['ProductGroupCode'] = 'offerphi';
                }
                $this->data['ProductGroup'][] = $row;
            }
            return $this->response();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 상품그룹 비활성화
    function disableItemGroup($param): array
    {
        $this->desc = "model::disableItemGroup";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['productGroupIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '400');
            }
            $sql = "SELECT ccm.ProductGroupIdx FROM phi.ClientCustomerManage as ccm
                    WHERE ccm.ProductGroupIdx = :productGroupIdx
                    ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['productGroupIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());

            if($total > 0){
                throw new \Exception('상품그룹이 이미 사용처에 등록되어있어 비활성화가 불가능합니다.', '400');
            }
            //상품 비활성화
            $sql = "UPDATE phi.ProductGroup
                    SET IsUse = b'0'
                    WHERE ProductGroupIdx = :productGroupIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['productGroupIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 상품그룹 등록
    function itemGroupInsert($param): array
    {
        $this->desc = 'model::itemGroupInsert';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['productGroupName'], $param['childProductIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            if (
                !preg_match($this->pattern['all'], $param['productGroupName'])
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', '400');
            }
            $this->conn->beginTransaction();
            $table = 'phi.ProductGroup';
            $item = [
                'businessManageIdx' => 1,
                'productGroupName' => $param['productGroupName'] ?? '',
                'productGroupCode' => $param['productGroupCode'] ?? 'DEVELOPER DEFINE',
                'activePoint' => $param['activePoint'] ?? 1,
                'isUse' => b'1'
            ];
            $childProductIdx = json_decode($param['childProductIdx'], true);
            $productGroupIdx = $this->insertUpdate([], $table, $item);
            if (count($childProductIdx) > 0) {
                $items = [];
                foreach ($childProductIdx as $key => $value) {
                    $items[] = [
                        'productGroupIdx' => $productGroupIdx,
                        'productIdx' => (int)$value,
                        'sort' => ($key + 1),
                    ];
                }
                $table = "phi.ProductGroupManage";
                $this->bulkInsertUpdate([], $table, $items);
            }

            $this->conn->commit();

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->conn = null;
            throw $e;
        }
    }

    //그룹명 수정
    function updateGroupName($param): array
    {
        $this->desc = 'model::updateGroupName';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['productGroupName'], $param['productGroupIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            if (!preg_match($this->pattern['all'], $param['productGroupName'])) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다..', '400');
            }
            $sql = "UPDATE phi.ProductGroup
                    SET ProductGroupName = :productGroupName
                    WHERE ProductGroupIdx = :productGroupIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupName', $param['productGroupName']);
            $stmt->bindValue(':productGroupIdx', $param['productGroupIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //그룹명 조회
    function searchProductGroupName($param): array
    {
        $this->desc = 'model::searchProductGroupName';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['productGroupIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            $sql = "SELECT ProductGroupIdx, ProductGroupName
                    FROM phi.ProductGroup
                    WHERE ProductGroupIdx = :productGroupIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['productGroupIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $this->data = $stmt->fetch() ?? [];

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //상품 조회(상품 식별자)
    function searchProductItem($param): array
    {
        $this->desc = 'model::searchProductItem';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['productIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            $sql = "SELECT
                        p.ProductIdx, p.ProductName, p.ParentProductIdx, p.Gender,
                        pc.ProductCatalogIdx, pc.CatalogName, pc.RefCode
                    FROM phi.Product AS p
                    LEFT JOIN phi.ProductCatalog AS pc
                    ON pc.ProductIdx = p.ProductIdx
                    WHERE p.ProductIdx = :productIdx
                    AND p.IsUse = b'1'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productIdx', $param['productIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $this->data['ProductIdx'] = $row['ProductIdx'];
                $this->data['ProductName'] = $row['ProductName'];
                $this->data['ParentProductIdx'] = $row['ParentProductIdx'];
                $this->data['Gender'] = $row['Gender'];
                if ($row['ProductCatalogIdx']) {
                    $this->data['ProductCatalogIdx'][] = $row['ProductCatalogIdx'];
                    $this->data['CatalogName'][] = $row['CatalogName'];
                    $this->data['RefCode'][] = $row['RefCode'];
                }
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //상품 비활성화
    function disableProduct($param): array
    {
        $this->desc = "model::disableProduct";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['productIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '400');
            }

            $sql = "SELECT pgm.ProductGroupIdx FROM phi.ProductGroupManage AS pgm
                    JOIN phi.ProductGroup AS pg ON pgm.ProductGroupIdx = pg.ProductGroupIdx AND pg.IsUse IS TRUE
                    WHERE pgm.ProductIdx = :productIdx
                    ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productIdx', $param['productIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());

            if($total > 0){
                throw new \Exception('상품그룹에 등록되어있어 비활성화가 불가능합니다.', '400');
            }

            //상품 비활성화
            $sql = "UPDATE phi.Product
                    SET IsUse = b'0'
                    WHERE ProductIdx = :productIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productIdx', $param['productIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //상품 등록 및 수정
    function createProduct($param): array
    {
        $this->desc = "model::createProduct";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['categoryIdx'], $param['productName'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            if (!preg_match($this->pattern['all'], $param['productName'])) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', '400');
            }

            $this->conn->beginTransaction();

            $productIdx = $param['productIdx'] ?: null;
            $productName = $param['productName'];
            $parentProductIdx = $param['categoryIdx'];
            $gender = $param['subdivision'] ?: null;
            $catalogList = $param['catalogList'] ? json_decode($param['catalogList'], true) : null;
            $delCatalogArr = $param['delCatalogArr'] ? json_decode($param['delCatalogArr'], true) : null;

            if ($productIdx) {
                //상품 수정
                $sql = "UPDATE phi.Product
                        SET ProductName = :productName,
                            ParentProductIdx = :parentProductIdx,";
                $sql .= ($gender) ? "Gender = :gender," : "";
                $sql .= "ModDatetime = NOW()
                         WHERE ProductIdx = :productIdx";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':productName', $productName);
                $stmt->bindValue(':parentProductIdx', $parentProductIdx, $this->conn::PARAM_INT);
                $stmt->bindValue(':productIdx', $productIdx, $this->conn::PARAM_INT);
                if ($gender) {
                    $stmt->bindValue(':gender', $gender, $this->conn::PARAM_INT);
                }
                $stmt->execute();

                if ($delCatalogArr) {
                    $delCatalogArr = implode(',', $delCatalogArr);
                    if ($delCatalogArr[-1] === ',') {
                        $delCatalogArr = substr($delCatalogArr, 0, -1);;
                    }
                    $sql = "DELETE FROM phi.ProductCatalog
                            WHERE ProductCatalogIdx IN ({$delCatalogArr})";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                }
                if ($catalogList) {
                    foreach ($catalogList as $item) {
                        if ($item['idx'] !== '') {
                            $sql = "UPDATE phi.ProductCatalog
                                    SET CatalogName = '{$item['name']}'
                                      , RefCode = '{$item['code']}'
                                    WHERE ProductCatalogIdx = {$item['idx']}";
                        } else {
                            $sql = "INSERT INTO phi.ProductCatalog (ProductIdx, CatalogName, RefCode)
                                    VALUES ({$productIdx}, '{$item['name']}', '{$item['code']}')";
                        }
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute();
                    }
                }
            } else {
                //상품 등록
                $sql = "INSERT INTO phi.Product (ProductName, ParentProductIdx";
                $sql .= ($gender) ? ", Gender" : "";
                $sql .= ") VALUES (:productName, :parentProductIdx";
                $sql .= ($gender) ? ", :gender" : "";
                $sql .= ")";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':productName', $productName);
                $stmt->bindValue(':parentProductIdx', $parentProductIdx, $this->conn::PARAM_INT);
                if ($gender) {
                    $stmt->bindValue(':gender', $gender, $this->conn::PARAM_INT);
                }
                $stmt->execute();

                $productIdx = $this->conn->lastInsertId();
                $insertVal = '';
                if ($catalogList) {
                    foreach ($catalogList as $key => $val) {
                        if ($key > 0) {
                            $insertVal .= ",";
                        }
                        $insertVal .= "({$productIdx}, '{$val['name']}', '{$val['code']}')";
                    }
                    $sql = "INSERT INTO phi.ProductCatalog (ProductIdx, CatalogName, RefCode)
                            VALUES {$insertVal}";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                }
            }

            $this->conn->commit();

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->conn = null;
            throw $e;
        }
    }

    // 그룹 전체 조회
    function justGroupList($param): array
    {
        $this->desc = 'justGroupList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            $sql = "    SELECT
                            p.ProductIdx, p.ProductName
                            , p2.ProductIdx AS ChildProductIdx
                            , p2.ProductName AS ChildProductName
                            , p2.Gender AS ChildGender
                          FROM phi.Product AS p
                     LEFT JOIN phi.Product AS p2
                            ON p2.ParentProductIdx = p.ProductIdx
                           AND p2.ParentProductIdx IS NOT NULL
                         WHERE p.ParentProductIdx IS NULL
                           AND p.IsUse = b'1'
                           AND p2.IsUse = b'1'";
            $stmt = $this->conn->query($sql);
            while ($row = $stmt->fetch()) {
                $this->data[$row['ProductIdx']]['ProductIdx'] = $row['ProductIdx'];
                $this->data[$row['ProductIdx']]['ProductName'] = $row['ProductName'];
                $this->data[$row['ProductIdx']]['ChildProductIdx'][] = $row['ChildProductIdx'];
                $this->data[$row['ProductIdx']]['ChildProductName'][] = $row['ChildProductName'];
                $this->data[$row['ProductIdx']]['ChildGender'][] = $row['ChildGender'];
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 상품 카탈로그 조회
    function catalogList($param): array
    {
        $this->desc = 'productList';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['productIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            $sql = "SELECT ProductCatalogIdx, RefCode, CatalogName
                    FROM phi.ProductCatalog
                    WHERE ProductIdx = :productIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productIdx', $param['productIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $this->data[] = $row;
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 리턴
    function response(): array
    {
        return ['code' => $this->code, 'data' => $this->data, 'msg' => $this->msg, 'desc' => $this->desc];
    }

    //상품그룹 조회
    function productGroupList($param): array
    {
        $this->desc = "model::productGroupList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = '';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['pg.ProductGroupName'])) {
                    $addSql = " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql = " AND {$param['keyword']} = '{$param['value']}'";
                }
            }
            // 기본 쿼리문
            $sql = "SELECT
                        pgm.ProductGroupIdx, p.ParentProductIdx, p.ProductName, pg.ProductGroupName, pg.RegDatetime, pgm.Sort
                    FROM phi.ProductGroupManage pgm
                    JOIN phi.ProductGroup pg ON pg.ProductGroupIdx = pgm.ProductGroupIdx
                    JOIN phi.Product p ON p.ProductIdx = pgm.ProductIdx
                    WHERE pg.BusinessManageIdx = 1 AND pg.IsUse = b'1'
                    {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $sql .= " ORDER BY pg.ProductGroupIdx DESC, pgm.Sort ASC";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($item = $stmt->fetch()) {
                $this->data['data'][$item['ProductGroupIdx']]['ProductGroupName'] = $item['ProductGroupName'];
                $this->data['data'][$item['ProductGroupIdx']]['ProductGroupIdx'] = $item['ProductGroupIdx'];
                $this->data['data'][$item['ProductGroupIdx']]['ParentProductIdx'] = $item['ParentProductIdx'];
                $this->data['data'][$item['ProductGroupIdx']]['ProductName'][] = $item['ProductName'];
                $this->data['data'][$item['ProductGroupIdx']]['RegDatetime'] = $item['RegDatetime'];
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 회원 조회
    function memberList($param): array
    {
        $this->desc = "model::memberList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !in_array($param['keyword'], ['o.RegDatetime', 'ccm.Category', 'ccm.ClientCustomerName', 'mm.MemberManageIdx', 'm.Name', 'm.Birth1', 'm.Gender', 'm.Phone', 'm.State', 'm.City']))
                || ($param['keyword'] !== 'm.Email' && $param['value'] && !preg_match($this->pattern['all'], $param['value']))
                || ($param['keyword'] === 'm.Email' && $param['value'] && !preg_match($this->pattern['email'], $param['value']))
                || ($param['column'] && !in_array($param['column'], ['o.RegDatetime', 'ccm.Category', 'ccm.ClientCustomerName', 'mm.MemberManageIdx', 'm.Name', 'Birth', 'Age', 'm.Gender', 'm.Phone', 'Address']))
                || ($param['sort'] && !in_array($param['sort'], ['asc', 'desc']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['o.RegDatetime', 'm.Name', 'm.Phone', 'm.Email', 'm.State', 'm.City', 'ccm.ClientCustomerName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    if ($param['keyword'] === 'ccm.Category') {
                        if ($param['value'] === '병원') {
                            $param['value'] = 'H';
                        } else if ($param['value'] === '약국') {
                            $param['value'] = 'P';
                        }
                    }
                    if ($param['keyword'] === 'm.Gender') {
                        if (in_array($param['value'], ['남', '남자', '남성', 'M'])) {
                            $param['value'] = 1;
                        } else if (in_array($param['value'], ['여', '여자', '여성', 'F'])) {
                            $param['value'] = 2;
                        }
                    }
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($param['column'] !== '' && $param['sort'] !== '') {
                switch ($param['column']) {
                    case 'Birth':
                    case 'Age':
                        $orderSql .= " m.Birth1 {$param['sort']}, m.Birth2 {$param['sort']} ";
                        break;
                    case 'Address':
                        $orderSql .= " m.State {$param['sort']}, m.City {$param['sort']}, m.FullCity {$param['sort']} ";
                        break;
                    default:
                        $orderSql .= " {$param['column']} {$param['sort']} ";
                }
            } else {
                $orderSql .= ' o.RegDatetime DESC ';
            }

            // 대상 전체 카운트
            $sql = " SELECT m.Name, m.Phone, m.Birth1, m.Birth2, m.Gender, m.Email, m.State, m.City,
                            m.FullCity,m.MemberIdx,
                            o.OrderIdx, o.ProductGroupIdx, o.RegDatetime,
                            tm.MemberIdx AS TestMember,
                            mm.MemberManageIdx,
                            ccm.ClientCustomerManageIdx, ccm.ClientCustomerName, ccm.Category
                       FROM order.Order AS o
                       JOIN phi.MemberManage AS mm
                         ON mm.MemberManageIdx = o.MemberManageIdx
                       JOIN phi.Member AS m
                         ON m.MemberIdx = mm.MemberIdx
                       JOIN phi.ClientCustomerManage AS ccm
                         ON ccm.ClientCustomerManageIdx = mm.ClientCustomerManageIdx
                  LEFT JOIN phi.TestMember AS tm
                         ON tm.MemberIdx = m.MemberIdx
                      WHERE mm.IsOut = b'0' #탈퇴회원 제외
                        AND o.ProductGroupIdx = :productGroupIdx #그룹식별자 특정
                        AND o.IsActive = b'1' #활성회원 선별
                        {$addSql}
                        {$orderSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();

            $rows = $stmt->fetchAll($this->conn::FETCH_ASSOC);
            $total = count($rows);
            $this->setPagination($total, $param);

            $items = array_slice($rows, $this->data['pagination']['start'], $param['entry']);
            $data = [];
            $orderIdxList = [];
            if (count($items) > 0) {
                foreach ($items as $item) {
                    $orderIdxList[] = $item['OrderIdx'];

                    $data["idx{$item['OrderIdx']}"] = [
                        'MemberIdx' => $item['MemberIdx'],
                        'MemberManageIdx' => $item['MemberManageIdx'],
                        'OrderIdx' => $item['OrderIdx'],
                        'Name' => $item['Name'],
                        'Phone' => $item['Phone'],
                        'Birth1' => $item['Birth1'],
                        'Birth2' => $item['Birth2'],
                        'Gender' => $item['Gender'] == '1' ? '남' : '여',
                        'Email' => $item['Email'],
                        'State' => $item['State'],
                        'City' => $item['City'],
                        'FullCity' => $item['FullCity'],
                        'ProductGroupIdx' => $item['ProductGroupIdx'],
                        'TestMember' => $item['TestMember'],
                        'RegDatetime' => substr($item['RegDatetime'], 0, 10) ?? '',
                        'ClientCustomerManageIdx' => $item['ClientCustomerManageIdx'],
                        'ClientCustomerName' => $item['ClientCustomerName'],
                        'Category' => $item['Category'],
                    ];
                }

                $sql = "SELECT ProductIdx
                        FROM phi.ProductGroupManage
                        WHERE ProductGroupIdx = :productGroupIdx
                        ORDER BY Sort ASC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
                $stmt->execute();
                $sort = "";
                while ($row = $stmt->fetch()) {
                    if ($sort !== "") {
                        $sort .= ",";
                    }
                    $sort .= $row['ProductIdx'];
                }
                $orderIdxStr = implode(',', $orderIdxList);

                $sql = "SELECT uls.OrderIdx, uls.ProductIdx, uls.Process, uls.StatusCode,
                               p.ParentProductIdx, p.ProductName
                          FROM phi.UserLatestStatus uls
                          JOIN phi.Product p
                            ON p.ProductIdx = uls.ProductIdx
                         WHERE uls.OrderIdx IN ({$orderIdxStr})
                      ORDER BY FIELD(uls.ProductIdx, {$sort}) ASC";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                while ($item = $stmt->fetch()) {
                    $data["idx{$item['OrderIdx']}"]['ProductIdx'] = $item['ProductIdx'];
                    $data["idx{$item['OrderIdx']}"]['Process'] = $item['Process'];
                    $data["idx{$item['OrderIdx']}"]['StatusCode'] = $item['StatusCode'];
                    $data["idx{$item['OrderIdx']}"]['ParentProductIdx'] = $item['ParentProductIdx'];
                    $data["idx{$item['OrderIdx']}"]['ProductName'] = $item['ProductName'];
                    $data["idx{$item['OrderIdx']}"]['IsSuccess'] = $item['Process'] === 'E' && $item['StatusCode'] === '20000' ? 'success' : 'fail';
                    $data["idx{$item['OrderIdx']}"]['LatestStatus'] = $this->defineStatusCode[$item['ParentProductIdx']][$item['ProductIdx']][$item['Process']][$item['StatusCode']] ?? '';
                }
            }

            $this->data['data'] = $data;

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 회원 정보 수정
    function updateMember($param): array
    {
        $this->desc = 'model::updateMember';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['orderIdx'], $param['memberIdx'], $param['state'], $param['city'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }
            if (
                !preg_match($this->pattern['kor'], $param['state'])
                || !preg_match($this->pattern['kor'], $param['city'])
                || (isset($param['email']) && !preg_match($this->pattern['email'], $param['email']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', '400');
            }

            $sql = "SELECT MM.MemberManageIdx, M.MemberIdx, M.Email, M.State, M.City, M.FullCity, AM.AGRE_DATE
                    FROM order.Order O
                    JOIN phi.MemberManage MM ON MM.MemberManageIdx = O.MemberManageIdx
                    JOIN phi.Member M ON M.MemberIdx = MM.MemberIdx
                    JOIN phi.AgreementManage AM ON (AM.MemberManageIdx, AM.OrderIdx) = (MM.MemberManageIdx, O.OrderIdx)
                    AND AM.ProductIdx IN (5,6)
                    WHERE O.OrderIdx = :OrderIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':OrderIdx', $param['orderIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $memberData = $stmt->fetch($this->conn::FETCH_ASSOC);

            $table = "phi.Member";
            $idx = ['memberIdx' => (int)$param['memberIdx']];
            $item = [
                'state' => $param['state'],
                'city' => $param['city'],
            ];
            if (isset($param['email'])) {
                $item['email'] = $param['email'];
            }
            $this->insertUpdate($idx, $table, $item);

            if (isset($param['email']) && $memberData['Email'] != $item['email'] && !isDev) {

                $method = "POST";
                $url = $this->apiLabgeUrl;
                $header = [
                    "Authorization: Bearer {$this->apiLabgeKey}",
                    "Content-Type: application/json"
                ];
                $body = [
                    'CompOrderNo' => (int)$memberData['MemberManageIdx'],
                    'CompOrderDate' => $memberData['AGRE_DATE'],
                    'EmailAddress' => $item['email'],
                ];
                $result = $this->curl($method, $url, $header, json_encode($body, true));
                $response = json_decode($result['response'], true);
                if ($result['code'] !== 200 || $response['status'] !== "200") {
                    throw new \Exception("failure: send updated info to labgenomics " . json_encode($response), "450");
                }
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 상품 리스트 조회
    function productList($param): array
    {
        $this->desc = "productList";
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }

            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['pp.ProductName', 'p.ProductName'])) {
                    $addSql = " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else {
                    $addSql = " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            // 카탈로그 개수 조회
            $sql = "SELECT ProductIdx, COUNT(ProductCatalogIdx) AS Cnt
                      FROM phi.ProductCatalog
                  GROUP BY ProductIdx";
            $stmt = $this->conn->query($sql);
            while ($row = $stmt->fetch()) {
                $rows[$row['ProductIdx']] = $row['Cnt'];
            }

            // 기본 쿼리문
            $sql = "SELECT
                        p.RegDatetime, p.ProductIdx, p.ProductName, p.Gender,
                        pp.ProductName AS CategoryName
                    FROM phi.Product p
                    JOIN phi.Product pp ON pp.ProductIdx = p.ParentProductIdx
                   WHERE p.IsUse = b'1'
                    {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);

            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $this->data['data'][] = [
                    'RegDatetime' => substr($row['RegDatetime'], 0, 10),
                    'ProductIdx' => $row['ProductIdx'],
                    'ProductName' => $row['ProductName'],
                    'Gender' => $row['Gender'],
                    'CategoryName' => $row['CategoryName'],
                    'CatalogNum' => $rows[$row['ProductIdx']] ?? '-',
                ];
            }

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //보험거래처 리스트 조회
    function insuranceList($param): array
    {
        $this->desc = 'model::insuranceList';

        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['keyword'], $param['value'], $param['entry'], $param['page'])) {
                throw new \Exception('필수 파라미터가 없습니다.', "404");
            }
            if (
                ($param['keyword'] && !preg_match($this->pattern['all'], $param['keyword']))
                || ($param['value'] && !preg_match($this->pattern['all'], $param['value']))
            ) {
                throw new \Exception('필수 파라미터가 올바르지 않습니다.', "400");
            }
            $addSql = ' ';
            if ($param['keyword'] !== '' && $param['value'] !== '') {
                if (in_array($param['keyword'], ['ASMH.RegDateTime', 'SCM.ServiceCompanyName'])) {
                    $addSql .= " AND {$param['keyword']} LIKE '%{$param['value']}%'";
                } else if ($param['keyword'] === 'ASMH.TransferMethodCode') {
                    if ($param['value'] === '수동') {
                        $addSql .= " AND {$param['keyword']} = 2";
                    } else if ($param['value'] === 'API') {
                        $addSql .= " AND {$param['keyword']} = 1";
                    }
                } else {
                    $addSql .= " AND {$param['keyword']} = '{$param['value']}'";
                }
            }

            $data = [];
            $sql = "SELECT
                        ASMH.AllocationServeManageHistoryIdx, ASMH.RegDatetime, SCM.ServiceCompanyManageIdx, SCM.ServiceCompanyName,
                        ASMH.TransferMethodCode, ASMH.AllocationServeType, ASMH.IsManual, ASMH.TotalServeLimit, ASMH.WeekServeLimit
                    FROM phi.AllocationServeManageHistory ASMH
                    JOIN phi.ServiceCompanyManage SCM ON SCM.ServiceCompanyManageIdx = ASMH.ServiceCompanyManageIdx
                    AND SCM.IsContract = b'1'
                    WHERE ASMH.ProductGroupIdx = :productGroupIdx
                    {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());
            $this->setPagination($total, $param);
            //main query
            $sql .= " ORDER BY ASMH.AllocationServeManageHistoryIdx DESC";
            $sql .= " LIMIT :start, :entry";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $param['gIdx'], $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $this->data['pagination']['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $param['entry'], $this->conn::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $data[] = [
                    'AllocationServeManageHistoryIdx' => $row['AllocationServeManageHistoryIdx'],
                    'RegDatetime' => $row['RegDatetime'] ? substr($row['RegDatetime'], 0, 10) : '',
                    'ServiceCompanyManageIdx' => $row['ServiceCompanyManageIdx'],
                    'ServiceCompanyName' => $row['ServiceCompanyName'],
                    'TransferMethodCode' => $row['TransferMethodCode'],
                    'AllocationServeType' => $row['AllocationServeType'],
                    'IsManual' => $row['IsManual'],
                    'TotalServeLimit' => $row['TotalServeLimit'],
                    'WeekServeLimit' => $row['WeekServeLimit']
                ];
            }
            $this->data['data'] = $data;

            // 거래처 셀렉트박스용
            $sql = "SELECT ServiceCompanyManageIdx AS `value`, ServiceCompanyName AS `text`
                    FROM phi.ServiceCompanyManage
                    WHERE IsContract = 1";
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetchAll() ?? [];
            $this->data['select::serviceCompanyManage'] = $row;

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    //보험거래처 등록 및 수정
    function insuranceUpdate($param): array
    {
        $this->desc = 'model::registInsurance';
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (
                !isset(
                    $param['serviceCompanyManage'],
                    $param['transferMethod'],
                    $param['isPilot'],
                    $param['isManual'],
                    $param['totalServeLimit'],
                    $param['weekServeLimit'],
                    $param['gIdx'])
            ) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }


            $table = "phi.AllocationServeManageHistory";
            $idx = isset($param['allocationServeManageHistoryIdx']) ? ['allocationServeManageHistoryIdx' => (int)$param['allocationServeManageHistoryIdx']] : [];
            $serviceCompanyManageIdx = (int)$param['serviceCompanyManage'];
            $transferMethod = (int)$param['transferMethod'];
            $allocationServeType = $param['isPilot'];
            $isManual = (int)$param['isManual'];
            $totalServeLimit = (int)$param['totalServeLimit'];
            $weekServeLimit = (int)$param['weekServeLimit'];
            $productGroupIdx = (int)$param['gIdx'];

            $item = [
                'transferMethodCode' => $transferMethod,
                'allocationServeType' => ($allocationServeType) ? 'pilot' : null,
                'isManual' => $isManual,
                'totalServeLimit' => $totalServeLimit,
                'weekServeLimit' => $weekServeLimit
            ];

            $this->conn->beginTransaction();

            //업데이트 조건문 추가 - 기존 백오피스 로직
            if (isset($param['allocationServeManageHistoryIdx'])) {
                $sql = "SELECT ServiceCompanyManageIdx, TransferMethodCode, AllocationServeType, IsManual, TotalServeLimit, WeekServeLimit
                        FROM {$table}
                        WHERE AllocationServeManageHistoryIdx = :allocationServeIdx";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':allocationServeIdx', $param['allocationServeManageHistoryIdx'], $this->conn::PARAM_INT);
                $stmt->execute();
                $allocationServeData = $stmt->fetch($this->conn::FETCH_ASSOC) ?? [];

                if ($allocationServeData['TransferMethodCode'] == $item['transferMethodCode']) {
                    unset($item['transferMethodCode']);
                }
                if ($allocationServeData['AllocationServeType'] == $item['allocationServeType']) {
                    unset($item['allocationServeType']);
                }
                if ($allocationServeData['IsManual'] == $item['isManual']) {
                    unset($item['isManual']);
                }
                if ($allocationServeData['TotalServeLimit'] == $item['totalServeLimit']) {
                    unset($item['totalServeLimit']);
                }
                if ($allocationServeData['WeekServeLimit'] == $item['weekServeLimit']) {
                    unset($item['weekServeLimit']);
                }
                if (count($item) === 0) {
                    throw new \Exception("변경사항이 없습니다.", "453");
                }

                $transferMethod = (int)$allocationServeData['TransferMethodCode'] ?? 0;
            } else {
                $sql = "SELECT TransferMethodCode FROM phi.ServiceCompanyManage
                        WHERE ServiceCompanyManageIdx = :serviceCompanyIdx AND IsContract = b'1'";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':serviceCompanyIdx', $serviceCompanyManageIdx, $this->conn::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch($this->conn::FETCH_ASSOC);
                $transferMethod = (int)$row['TransferMethodCode'] ?? 0;
                if (!$transferMethod) {
                    throw new \Exception("IB거래처 조회 오류", "451");
                }
            }
            if (isset($item['transferMethodCode'])) {
                if ($transferMethod != $item['transferMethodCode']) {
                    $sql = "UPDATE phi.ServiceCompanyManage
                            SET TransferMethodCode = :transferMethod
                            WHERE ServiceCompanyManageIdx = :serviceCompanyIdx";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':transferMethod', $item['transferMethodCode'], $this->conn::PARAM_INT);
                    $stmt->bindValue(':serviceCompanyIdx', $serviceCompanyManageIdx, $this->conn::PARAM_INT);
                    $stmt->execute();
                }
            }

            $item['serviceCompanyManageIdx'] = $serviceCompanyManageIdx;
            $item['productGroupIdx'] = $productGroupIdx;
            if (!$allocationServeType) {
                unset($item['allocationServeType']);
            }

            $this->insertUpdate($idx, $table, $item);

            $this->conn->commit();

            $this->conn = null;
            return $this->response();
        } catch (\Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->conn = null;
            throw $e;
        }
    }

    //보험 거래처 제공량 조회
    function searchInsurance($param): array
    {
        $this->desc = 'model::searchInsurance';

        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }
            if (!isset($param['allocationServeManageHistoryIdx'])) {
                throw new \Exception('필수 파라미터가 없습니다.', '404');
            }

            $sql = "SELECT
                        ASMH.AllocationServeManageHistoryIdx, ASMH.RegDatetime, SCM.ServiceCompanyManageIdx, SCM.ServiceCompanyName,
                        ASMH.TransferMethodCode, ASMH.AllocationServeType, ASMH.IsManual, ASMH.TotalServeLimit, ASMH.WeekServeLimit
                    FROM phi.AllocationServeManageHistory ASMH
                    JOIN phi.ServiceCompanyManage SCM ON SCM.ServiceCompanyManageIdx = ASMH.ServiceCompanyManageIdx
                    AND SCM.IsContract = b'1'
                    WHERE ASMH.AllocationServeManageHistoryIdx = :allocationServeManageHistoryIdx";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':allocationServeManageHistoryIdx', $param['allocationServeManageHistoryIdx'], $this->conn::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch() ?? [];
            if ($row) {
                $this->data = [
                    'AllocationServeManageHistoryIdx' => $row['AllocationServeManageHistoryIdx'],
                    'RegDatetime' => $row['RegDatetime'],
                    'ServiceCompanyManageIdx' => $row['ServiceCompanyManageIdx'],
                    'ServiceCompanyName' => $row['ServiceCompanyName'],
                    'TransferMethodCode' => $row['TransferMethodCode'],
                    'AllocationServeType' => $row['AllocationServeType'],
                    'IsManual' => $row['IsManual'],
                    'TotalServeLimit' => $row['TotalServeLimit'],
                    'WeekServeLimit' => $row['WeekServeLimit']
                ];
            }

            $this->conn = null;
            return $this->response();

        } catch (\Exception $e) {
            $this->conn = null;
            throw $e;
        }
    }

    // 페이징
    function setPagination($total, $param): void
    {
        try {
            if (!isset($param['entry'], $param['page'])) {
                throw new \Exception('페이징 필수 파라미터가 없습니다.', '404');
            }

            /* paging : 한 페이지 당 데이터 개수 */
            $list_num = $param['entry'];

            /* paging : 블록 노출 개수*/
            $page_num = 5;

            /* paging : 현재 페이지 */
            $page = $param['page'] ?: 1;

            /*page가 1보다 작을 경우 1로 고정*/
            if ($page < 1) {
                $page = 1;
            }

            /* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수, ceil : 올림값, floor : 내림값, round : 반올림 */
            $total_page = ceil($total / $list_num);
            // echo "전체 페이지 수 : ".$total_page;

            /* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
            $totalBlock = ceil($total_page / $page_num);

            /* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
            $now_block = ceil($page / $page_num);

            /* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
            $sPage = ($now_block - 1) * $page_num + 1;
            // 데이터가 0개인 경우
            if ($sPage <= 0) {
                $sPage = 1;
            };

            /* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
            $ePage = $now_block * $page_num;
            // 마지막 번호가 전체 페이지 수를 넘지 않도록
            if ($ePage > $total_page) {
                $ePage = $total_page;
            };

            $start = ($param['page'] - 1) * $param['entry'];

            $response = [
                'sPage' => $sPage,
                'ePage' => $ePage,
                'totalPage' => $total_page,
                'currentBlock' => $now_block,
                'totalBlock' => $totalBlock,
                'start' => $start,
                'totalCnt' => $total,
            ];

            $this->data['pagination'] = $response;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    // 오류기록
    function errorLog($msg, $code, $data): void
    {
        if (!$this->conn) {
            $this->conn = DB::connection()->getPdo();
        }

        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        $jsonData = '';
        if (is_array($data)) {
            $jsonData = json_encode($data, true);
        } else {
            $jsonData = $data;
        }

        $sql = "INSERT INTO log.ErrorLog (Code, Msg, Request, Referer, IpAddress)
                VALUES (:Code, :Msg, :Request, :Referer, :IpAddress)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':Code', $code);
        $stmt->bindValue(':Msg', $msg);
        $stmt->bindValue(':Request', $jsonData);
        $stmt->bindValue(':Referer', $_SERVER['HTTP_REFERER'] ?? '');
        $stmt->bindValue(':IpAddress', $ipaddress);
        $stmt->execute();

        $this->conn = null;
    }
}
