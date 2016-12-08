<?php



namespace App\Http\Controllers;

use Flash;
use Illuminate\Http\Request;
use Redirect;
use Validator;

/**
 * Class MaillistController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class MaillistController extends Controller
{
    /**
     * @return mixed
     */
    public function getMaillist()
    {
        return view('frontend.maillist.maillist');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function postMaillist(Request $request)
    {
        $formData = [
            'email' => $request->get('email'),
        ];

        $rules = [
            'email' => 'required|email|unique:maillist,email',
        ];

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return Redirect::action('MaillistController@getMaillist')->withErrors($validation)->withInput();
        }

        $maillist = new Maillist();
        $maillist->email = $formData['email'];
        $maillist->save();

        Flash::info('success');

        return Redirect::action('HomeController@index');
    }

    public function sendMail()
    {
        $formData = [];
        $mailer = new Mailer();
        $mailer->send('emails.newsletter', 'noreply@graceframe.com', 'Title', $formData);
    }
}
