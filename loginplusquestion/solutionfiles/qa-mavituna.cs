using System;
using System.Text;
using System.Text.RegularExpressions;
using MSL.Core.Components.Forms;
using MSL.Core.Process.Authentication;
using MSL.Core.Process.Extensibility;
using MSL.Core.Process.Network.Http;

[ExtensibilityClass]
public static class MyScriptMethods
{

    private static string TwoFactorAnswer;
    private static string TwoFactorQuestion;

    [ExtensibilityMethod(typeof(FormAuthenticationBeforeRequestHandler))]
    public static void BeforeAuthenticationMacroRequest(IHttpRequest request)
    {
        if (request.Id == "Request2")
        {
            request.Body = request.Body.Replace("{{q}}", TwoFactorQuestion);
            request.Body = request.Body.Replace("{{a}}", TwoFactorQuestion);
            request.Body = request.Body.Replace("{{answer}}", TwoFactorAnswer);
            TwoFactorAnswer = string.Empty;
        }
        else
        {
            return;
        }
    }

    [ExtensibilityMethod(typeof(FormAuthenticationAfterResponseHandler))]
    public static void AfterAuthenticationMacroResponse(IHttpRequest request)
    {
        if (request.Id == "Request1")
        {
            string TwoFactorHttpResponseBody;
            string TwoFactorString = "";
            TwoFactorHttpResponseBody = request.Response.Body.ToString();

            Match TwoFactorChar = Regex.Match(TwoFactorHttpResponseBody, "answer_[0-9]*", RegexOptions.IgnoreCase);

            if (TwoFactorChar.ToString() == "answer_1234")
            {
                TwoFactorAnswer = "apple1";
                TwoFactorQuestion = "1234";
            }
            else if (TwoFactorChar.ToString() == "answer_817")
            {
                TwoFactorAnswer = "apple2";
                TwoFactorQuestion = "817";
            }
            else if (TwoFactorChar.ToString() == "answer_423")
            {
                TwoFactorAnswer = "apple3";
                TwoFactorQuestion = "423";
            }

            TwoFactorString = "";
        }
        else
        {
            return;
        }
    }
}