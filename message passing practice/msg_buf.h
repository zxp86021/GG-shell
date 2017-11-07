#define MSGSIZE 64
#define MSGNUM 3

struct msgbuf {
	long mtype;
	char mtext[MSGSIZE];
}; 
