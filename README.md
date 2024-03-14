# RemoteTemplate

## Getting Started

1. The first step in getting started is to make sure to create a backup of what you currently have in your remote folder. These includes all your labs and assignments.
2. Next is to clone the repo to your local using the command `git clone https://github.com/ayodele-olufemi/RemoteTemplate.git`.
3. Next, open the cloned project in your code editor. I use VS Code. Switch to your branch and do a git merge so as to be current with `main` branch using the following commands:
   - `git checkout ayBranch`. Replace 'ayBranch' with your branch name i.e. dawitBranch, katieBranch, maryamaBranch.
   - `git merge origin/main`.
4. Here is what my home page looks like:
   ![image](https://github.com/ayodele-olufemi/RemoteTemplate/assets/35311006/ed790a99-2694-46da-a957-e8cf189978e4)
5. This step is optional, so long as you can figure out how to match the way I split into `header`, `menu` and `footer` with conflict. However, if you'd prefer to just go with my format (for simplicity sake):
   - You may edit the root `index.php` page to match your data and pictures.
   - Edit the root `css/style.css` file to match your colors.
   - Edit `includes/footer.php` file line 12.
   - Edit `includes/header.php` file lines 7, 13, 50. and change pictures as appropriate.
   - Edit `includes/menu.php` file lines 6,
   - Also make appropriate changes to the root JavaScript file `js/index.js`, lines 36 and 43.
   - Using SCP, copy the files to your remote location and view in browser using the remote url i.e. `http://sp-cfsics.metrostate.edu/~ics325sp2409/index.php`. Remember to replace your ID.
   - If everything looks good, copy your labs into the respective folders. I have left my lab3 solution for reference on where your subsequent lab contents should go.

## GradeBook App Project

Now that we're done setting up the format, we can then make some change to make the project run on our remote. If you alread attempted to click on `Phase 4` link on the menu, you'll get some errors! Let's fix those errors now.

I basically used the Professors instruction for lab 7 for the remote database access.

1. Edit `includes/headerLoggedIn.php` and `includes/headerOthers.php` files line 7. Only replace your ID.
2. Edit `secure/config.php` file lines 15, 16, 17. For line 17, put your 4-digit MySQL server password in the quotes.
3. Execute `projects/phase4/sqlScriptRemote.sql` on remote server. Message in Discord chat if you need help with this.
