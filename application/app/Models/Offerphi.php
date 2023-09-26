<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

// 인터페이스 정의
interface AdminInterface
{
    // pagination
    public function pagination($total, $param);
}

// 추상클래스 정의
abstract class AdminManage extends Model implements AdminInterface
{
    public string $code = '200';
    public array $data = [];
    public string $msg = '';
    public string $desc = '';

    // paging
    public function pagination($total, $param): array
    {
        try {
            $entry = isset($param['entry']) ? ($param['entry'] > 0 ? : 50) : 50;
            $page = isset($param['page']) ? ($param['page'] > 0 ? : 1) : 1;
/*            if (!isset($param['entry'], $param['page'])) {
                throw new \Exception('페이징 필수 파라미터가 없습니다.', '404');
            }*/
            /* paging : 한 페이지 당 데이터 개수 */
            $list_num = $entry;
            /* paging : 블록 노출 개수*/
            $page_num = 5;
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
            $start = ($page - 1) * $entry;
            return [
                'sPage' => $sPage,
                'ePage' => $ePage,
                'totalPage' => $total_page,
                'currentBlock' => $now_block,
                'totalBlock' => $totalBlock,
                'start' => $start,
                'totalCnt' => $total,
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // return
    function response(): array
    {
        return ['code' => $this->code, 'data' => $this->data, 'msg' => $this->msg, 'desc' => $this->desc];
    }
}

class Offerphi extends AdminManage
{
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function goodsList($param): array
    {
        try {
            if (!$this->conn) {
                $this->conn = DB::connection()->getPdo();
            }

            // define param
            $column = isset($param['column']) ?? '';
            $sort = isset($param['sort']) ?? '';
            $keyword = isset($param['keyword']) ?? '';
            $value = isset($param['value']) ?? '';
            $gIdx = $param['gIdx'];
            $entry = isset($param['entry']) ? ($param['entry'] > 0 ? : 50) : 50;
            $page = isset($param['page']) ? ($param['page'] > 0 ? : 1) : 1;


            $addSql = ' ';
            if ($keyword && $value ) {
                if (in_array($keyword, ['scm.ServiceCompanyName','testValue'])) {
                    $addSql .= " AND {$keyword} LIKE '%{$value}%'";
                } else {
                    $addSql .= " AND {$keyword} = '{$value}'";
                }
            }

            $orderSql = ' ORDER BY ';
            if ($column && $sort) {
                $orderSql .= " {$column} {$sort}, gm.RegDatetime DESC ";
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
                   WHERE gm.ProductGroupIdx = :productGroupIdx
                     AND scm.IsContract = TRUE
                     AND gm.IsUse = TRUE
                     {$addSql}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $gIdx, $this->conn::PARAM_INT);
            $stmt->execute();
            $total = count($stmt->fetchAll());

            $paginate = $this->pagination($total, $param);

            $data = [];
            // 최근 상태 조회
            $sql .= $orderSql;
            $sql .= " LIMIT :start , :entry";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':productGroupIdx', $gIdx, $this->conn::PARAM_INT);
            $stmt->bindValue(':start', $paginate['start'], $this->conn::PARAM_INT);
            $stmt->bindValue(':entry', $entry, $this->conn::PARAM_INT);
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
            throw $e;
        }
    }
}
