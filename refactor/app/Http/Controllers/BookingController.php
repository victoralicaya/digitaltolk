<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */
class BookingController extends Controller
{

    /**
     * @var BookingRepository
     */
    protected $bookingRepository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if($user->user_type == env('ADMIN_ROLE_ID') || $user->user_type == env('SUPERADMIN_ROLE_ID')) {
            $response = $this->bookingRepository->getAll($request->all());
        } else {
            $response = $this->bookingRepository->getUsersJobs($user->id);
        }

        return response($response, 200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $job = $this->bookingRepository->with('translatorJobRel.user')->find($id);

        return response($job, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $response = $this->bookingRepository->store($request->__authenticatedUser, $data);

        return response($response, 201);

    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $cuser = auth()->user();
        $response = $this->bookingRepository->updateJob($id, array_except($data, ['_token', 'submit']), $cuser);

        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function immediateJobEmail(Request $request)
    {
        // $adminSenderEmail = config('app.adminemail');
        $data = $request->all();

        $response = $this->bookingRepository->storeJobEmail($data);

        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getHistory(Request $request)
    {
        $user_id = auth()->user()->id;
        $response = $this->bookingRepository->getUsersJobsHistory($user_id, $request->all());

        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function acceptJob(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        $response = $this->bookingRepository->acceptJob($data, $user);

        return response($response, 200);
    }

    public function acceptJobWithId(Request $request)
    {
        $data = $request->get('job_id');
        $user = auth()->user();

        $response = $this->bookingRepository->acceptJobWithId($data, $user);

        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelJob(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        $response = $this->bookingRepository->cancelJobAjax($data, $user);

        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function endJob(Request $request)
    {
        $data = $request->all();

        $response = $this->bookingRepository->endJob($data);

        return response($response, 200);

    }

    public function customerNotCall(Request $request)
    {
        $data = $request->all();

        $response = $this->bookingRepository->customerNotCall($data);

        return response($response, 200);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPotentialJobs(Request $request)
    {
        // $data = $request->all();
        $user = auth()->user();

        $response = $this->bookingRepository->getPotentialJobs($user);

        return response($response, 200);
    }

    public function distanceFeed(Request $request)
    {
        $data = $request->all();

        $response = $this->bookingRepository->distanceFeed($data);

        return response($response, 200);
    }

    public function reopen(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingRepository->reopen($data);

        return response($response, 200);
    }

    public function resendNotifications(Request $request)
    {
        $data = $request->all();
        $job = $this->bookingRepository->find($data['jobid']);
        $job_data = $this->bookingRepository->jobToData($job);
        $this->bookingRepository->sendNotificationTranslator($job, $job_data, '*');

        return response([
            'success' => 'Push sent'
        ], 200);
    }

    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resendSMSNotifications(Request $request)
    {
        $data = $request->all();
        $job = $this->bookingRepository->find($data['jobid']);
        // $job_data = $this->bookingRepository->jobToData($job);

        try {
            $this->bookingRepository->sendSMSNotificationToTranslator($job);
            return response([
                'success' => 'SMS sent'
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ]);
        }
    }

}
