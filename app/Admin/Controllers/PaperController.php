<?php

namespace App\Admin\Controllers;

use App\Admin\Models\School;
use App\Admin\Models\Participant;
use App\Admin\Models\Paper;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Auth\Permission;
use App\Admin\Models\Season;
// use App\Admin\Extensions\Tools\PublishPost;
// use Intervention\Image\ImageManagerStatic as Image;

use App\Helpers\Utility;
use Illuminate\Support\MessageBag;
use App\Admin\Extensions\Tools\PaperSelect;

class PaperController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('manage_membership');

        return Admin::content(function (Content $content) {
            $content->header('答題卷');
            $content->description('management');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        Permission::check('manage_membership');

        return Admin::content(function (Content $content) use ($id) {
            $content->header('答題卷');
            $content->description('edit');

            $content->body($this->form()->edit($id));

            // Show paper question list
            $paper = Paper::with('questions')->findOrFail($id);
            // Build questions table
            $questions = $paper->questions;
            foreach ($questions as $key => $q) {
                $answer = $q->pivot->answer;
                $rows[$key] = [
                  $q->name,
                  ($answer) ? Utility::decodeUnicode($answer) : null,
                  ($q->pivot->correct) ? '<span class="label label-success">Yes</span>' : null,
                  $q->pivot->score,
                  $q->pivot->seconds_used,
                ];
            }

            $headers = ['問題', '回答', '是否正確', '得分', '用時'];
            $table = new Table($headers, $rows);
            $content->row((new Box('本答卷問題', $table))->style('default')->solid());
        });
    }

    // $participant = Participant::find(14);
    // // Question ids which has been wrong in recently
    // $wrong_question_ids = [];
    // $paper_ids = [];
    // // Get 50 recently score<100 papers get all wrong question isd
    // $papers = $participant->papers()->orderBy('created_at', 'desc')->where('score', '<', '100')->take(50)->get();
    // foreach ($papers as $paper) {
    //     $questions = $paper->questions;
    //     foreach ($questions as $key => $q) {
    //         if ($q->pivot->correct == 0) {
    //             if (in_array($q->id, $wrong_question_ids) == false) {
    //                 array_push($wrong_question_ids, $q->id);
    //             }
    //             echo $q->id;
    //             echo "\r\n";
    //         }
    //     }
    // }

    // // Get 50 recently score = 100 papers to verify if the wrong question exists
    // $papers = $participant->papers()->orderBy('created_at', 'desc')->where('score', '100')->take(50)->get();
    // foreach ($papers as $paper) {
    //     $questions = $paper->questions;
    //     foreach ($questions as $key => $q) {
    //         if (in_array($q->id, $wrong_question_ids)) {
    //             if (in_array($q->pivot->paper_id, $paper_ids) == false) {
    //                 array_push($paper_ids, $q->pivot->paper_id);
    //             }
    //             echo $q->pivot->paper_id;
    //             echo "\r\n";
    //         }
    //     }
    // }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        Permission::check('manage_membership');

        return Admin::content(function (Content $content) {
            $content->header('答題卷');
            $content->description('create');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Paper::class, function (Grid $grid) {
            $grid->model()->orderBy('finished_at', 'desc');
            $grid->id('ID');
            $grid->number('參考編號')->label('default');
            $grid->column('participant.name', '姓名')->label('success');
            $grid->participant_id('學校')->display(function ($participant_id) {
                if ($participant_id) {
                    $result = Participant::where('id', $participant_id)->with('school')->first();

                    if ($result) {
                        return $result->school ? $result->school->name : null;
                    }
                }

                return null;
            })->label('default');
            $grid->column('season.name', '賽季');
            $grid->status('答卷狀態')->display(function ($status) {
                $statusMapping = [
                    'creating' => '生成中',
                    'created' => '已生成',
                    'assigned' => '已分配',
                    'processing' => '答題中',
                    'reviewing' => '評分中',
                    'finished' => '已答題',
                    'canceled' => '已取消',
                    'voided' => '已作廢',
                    ];

                return (array_key_exists($status, $statusMapping)) ? $statusMapping[$status] : $status;
            })->label('default');

            $grid->score('得分')->badge('green')->sortable();
            $grid->seconds_used('答題秒數')->badge('gray')->sortable();
            $grid->started_at('開卷時間')->sortable();
            $grid->finished_at('結束時間')->sortable();
            // $grid->created_at('創建時間');

            $grid->filter(function ($filter) {
                // $filter->useModal();
                // 禁用id查询框
                $filter->disableIdFilter();
                $filter->like('number', 'Paper number');
                $filter->where(function ($query) {
                    $query->whereHas('participant', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, 'User Participants name');
                $filter->where(function ($query) {
                    $query->whereHas('participant', function ($query) {
                        $query->where('school_id', $this->input);
                    });
                }, 'School')->select(School::approved()->get()->pluck('name', 'id'));
                $filter->equal('season_id', 'Season')->select(Season::all()->pluck('name', 'id'));
                $filter->equal('status', 'Status')->select(
                    [
                    'creating' => '生成中',
                    'created' => '已生成',
                    'assigned' => '已分配',
                    'processing' => '答題中',
                    'reviewing' => '評分中',
                    'finished' => '已答題',
                    'canceled' => '已取消',
                    'voided' => '已作廢',
                    ]
                );
                // $filter->between('created_at', 'Create time')->datetime();
                // $filter->between('started_at', 'Started time')->datetime();
            });

            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->tools(function (Grid\Tools $tools) {
                // $tools->append('<a class="btn btn-sm btn-default form-history-bac" style="float: right;margin-right: 20px;" href="你要跳转的页面"><i class="fa fa-bars"></i>&nbsp;生成試卷</a>');
                $tools->append(new PaperSelect());
            });

            // -------Grid基本設置-------
            //   $grid->disableRowSelector();
            //   $grid->disableExport();
            $grid->disableCreateButton();
            $grid->perPages([10, 20, 30, 40, 50]);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Paper::class, function (Form $form) {
            $form->tab('問卷信息', function ($form) {
                $form->display('id', ' 問卷 ID');
                $form->display('number', '參考編號');
                $form->display('season.name', '賽季');
                $form->display('status', '問卷狀態')->with(function ($status) {
                    $statusMapping = [
                    'creating' => '生成中',
                    'created' => '已生成',
                    'assigned' => '已分配',
                    'processing' => '答題中',
                    'reviewing' => '評分中',
                    'finished' => '已答題',
                    'canceled' => '已取消',
                    'voided' => '已作廢',
                    ];

                    return (array_key_exists($status, $statusMapping)) ? $statusMapping[$status] : $status;
                });
                $form->display('difficulty', '問卷難度');
                $form->display('created_at', '生成時間');
            })->tab('答題信息', function ($form) {
                $form->display('participant.name', '答題學生');
                $form->display('participant_id', '學校')->with(function ($participant_id) {
                    if ($participant_id) {
                        $participant = Participant::with('school')->find($participant_id);
                        if ($participant->school) {
                            return $participant->school->name;
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                });
                $form->display('score', '得分');
                $form->display('seconds_used', '答題時間');
                $form->display('started_at', '開始時間');
                $form->display('finished_at', '結束時間');
            });

            $form->saving(function (Form $form) {
            });

            // $form->saved(function ($form) {
            //     $success = new MessageBag([
            //         'title'   => '保存成功',
            //         // 'message' => 'message....',
            //     ]);
            //     // use redirect() instead of back(), to stay edit from create.
            //     return redirect(route('season.edit', [$form->model()->id]))->with(compact('success'));
            // });

            $form->tools(function (Form\Tools $tools) {
            });
        });
    }
}
